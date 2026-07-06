<?php

class TurmaModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function listarTodas($filtros = [])
    {
        $sql = "SELECT t.*, c.nome AS curso_nome, c.tipo_curso, c.area,
                       vp.professores
                FROM turma t
                JOIN curso c ON c.id_curso = t.id_curso
                LEFT JOIN vw_professores_turma vp ON vp.id_turma = t.id_turma
                WHERE 1=1";
        $params = [];

        if (!empty($filtros['turno'])) {
            $sql .= " AND t.turno = :turno";
            $params[':turno'] = $filtros['turno'];
        }
        if (!empty($filtros['tipo_curso'])) {
            $sql .= " AND c.tipo_curso = :tipo";
            $params[':tipo'] = $filtros['tipo_curso'];
        }
        if (!empty($filtros['area'])) {
            $sql .= " AND c.area = :area";
            $params[':area'] = $filtros['area'];
        }
        if (isset($filtros['ativa'])) {
            $sql .= " AND t.ativa = :ativa";
            $params[':ativa'] = $filtros['ativa'];
        }
        if (!empty($filtros['busca'])) {
            $sql .= " AND (t.codigo LIKE :busca OR c.nome LIKE :busca)";
            $params[':busca'] = '%' . $filtros['busca'] . '%';
        }

        $sql .= " ORDER BY t.data_inicio DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function listarAtivas()
    {
        return $this->pdo->query(
            "SELECT t.id_turma, t.codigo, c.nome AS curso_nome, t.turno
             FROM turma t JOIN curso c ON c.id_curso = t.id_curso
             WHERE t.ativa = TRUE ORDER BY t.codigo"
        )->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.*, c.nome AS curso_nome FROM turma t
             JOIN curso c ON c.id_curso = t.id_curso WHERE t.id_turma = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function criar($dados)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO turma (codigo, id_curso, turno, data_inicio, data_termino_prevista, dias_semana, descricao, observacao)
             VALUES (:codigo, :curso, :turno, :inicio, :termino, :dias, :desc, :obs)"
        );
        $stmt->execute([
            ':codigo'  => $dados['codigo'],
            ':curso'   => $dados['id_curso'],
            ':turno'   => $dados['turno'],
            ':inicio'  => $dados['data_inicio'],
            ':termino' => $dados['data_termino_prevista'],
            ':dias'    => $dados['dias_semana'],
            ':desc'    => $dados['descricao'] ?? null,
            ':obs'     => $dados['observacao'] ?? null
        ]);
        return $this->pdo->lastInsertId();
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE turma SET codigo = :codigo, id_curso = :curso, turno = :turno,
             data_inicio = :inicio, data_termino_prevista = :termino, dias_semana = :dias,
             descricao = :desc, observacao = :obs WHERE id_turma = :id"
        );
        $stmt->execute([
            ':id'      => $id,
            ':codigo'  => $dados['codigo'],
            ':curso'   => $dados['id_curso'],
            ':turno'   => $dados['turno'],
            ':inicio'  => $dados['data_inicio'],
            ':termino' => $dados['data_termino_prevista'],
            ':dias'    => $dados['dias_semana'],
            ':desc'    => $dados['descricao'] ?? null,
            ':obs'     => $dados['observacao'] ?? null
        ]);
    }

    public function alterarStatus($id, $ativa)
    {
        $stmt = $this->pdo->prepare("UPDATE turma SET ativa = :ativa WHERE id_turma = :id");
        $stmt->execute([':id' => $id, ':ativa' => $ativa]);
    }

    // --- Professores da turma ---

    public function listarProfessores($idTurma)
    {
        $stmt = $this->pdo->prepare(
            "SELECT u.id_usuario, u.nome, u.email, pt.principal
             FROM professor_turma pt
             JOIN usuario u ON u.id_usuario = pt.id_usuario
             WHERE pt.id_turma = :turma ORDER BY pt.principal DESC, u.nome"
        );
        $stmt->execute([':turma' => $idTurma]);
        return $stmt->fetchAll();
    }

    public function vincularProfessor($idTurma, $idUsuario, $principal = false)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO professor_turma (id_turma, id_usuario, principal)
             VALUES (:turma, :usuario, :principal)"
        );
        $stmt->execute([':turma' => $idTurma, ':usuario' => $idUsuario, ':principal' => $principal]);
    }

    public function desvincularProfessor($idTurma, $idUsuario)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM professor_turma WHERE id_turma = :turma AND id_usuario = :usuario"
        );
        $stmt->execute([':turma' => $idTurma, ':usuario' => $idUsuario]);
    }

    public function definirProfessorPrincipal($idTurma, $idUsuario)
    {
        $this->pdo->prepare("UPDATE professor_turma SET principal = FALSE WHERE id_turma = :turma")
            ->execute([':turma' => $idTurma]);
        $this->pdo->prepare("UPDATE professor_turma SET principal = TRUE WHERE id_turma = :turma AND id_usuario = :usuario")
            ->execute([':turma' => $idTurma, ':usuario' => $idUsuario]);
    }

    public function atualizarDataTerminoCalculada($idTurma)
    {
        $stmt = $this->pdo->prepare(
            "SELECT data_termino_prevista, dias_semana FROM turma WHERE id_turma = :id"
        );
        $stmt->execute([':id' => $idTurma]);
        $turma = $stmt->fetch();

        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM dia_cancelado WHERE id_turma = :id"
        );
        $stmt->execute([':id' => $idTurma]);
        $diasCancelados = $stmt->fetchColumn();

        $novaData = new DateTime($turma['data_termino_prevista']);
        $diasAdicionados = 0;
        $diasSemana = explode(',', $turma['dias_semana']);
        $mapaDias = ['Dom'=>0,'Seg'=>1,'Ter'=>2,'Qua'=>3,'Qui'=>4,'Sex'=>5,'Sab'=>6];

        $diasPermitidos = [];
        foreach ($diasSemana as $dia) {
            $dia = trim($dia);
            if (isset($mapaDias[$dia])) {
                $diasPermitidos[] = $mapaDias[$dia];
            }
        }

        while ($diasAdicionados < $diasCancelados) {
            $novaData->modify('+1 day');
            if (in_array((int)$novaData->format('w'), $diasPermitidos)) {
                $diasAdicionados++;
            }
        }

        $stmt = $this->pdo->prepare("UPDATE turma SET data_termino_calculada = :data WHERE id_turma = :id");
        $stmt->execute([':id' => $idTurma, ':data' => $novaData->format('Y-m-d')]);
    }

    public function progresso($idTurma)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM vw_progresso_turma WHERE id_turma = :id");
        $stmt->execute([':id' => $idTurma]);
        return $stmt->fetch();
    }
}
