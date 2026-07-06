<?php

class ReservaModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function listarPorSemana($idUnidade, $dataInicio, $dataFim, $filtros = [])
    {
        $sql = "SELECT r.*, s.numero AS sala_numero, s.tipo AS sala_tipo,
                       t.codigo AS turma_codigo, c.nome AS curso_nome
                FROM reserva r
                JOIN sala s ON s.id_sala = r.id_sala
                JOIN turma t ON t.id_turma = r.id_turma
                JOIN curso c ON c.id_curso = t.id_curso
                WHERE s.id_unidade = :unidade
                  AND r.data BETWEEN :inicio AND :fim
                  AND r.status = 'Ativa'";
        $params = [':unidade' => $idUnidade, ':inicio' => $dataInicio, ':fim' => $dataFim];

        if (!empty($filtros['turno'])) {
            $sql .= " AND r.turno = :turno";
            $params[':turno'] = $filtros['turno'];
        }
        if (!empty($filtros['tipo_sala'])) {
            $sql .= " AND s.tipo = :tipo";
            $params[':tipo'] = $filtros['tipo_sala'];
        }
        if (!empty($filtros['andar'])) {
            $sql .= " AND s.andar = :andar";
            $params[':andar'] = $filtros['andar'];
        }

        $sql .= " ORDER BY s.numero, r.data, r.turno";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function verificarConflito($idSala, $data, $turno, $excluirReserva = null)
    {
        $sql = "SELECT id_reserva FROM reserva
                WHERE id_sala = :sala AND data = :data AND turno = :turno AND status = 'Ativa'";
        $params = [':sala' => $idSala, ':data' => $data, ':turno' => $turno];

        if ($excluirReserva) {
            $sql .= " AND id_reserva != :excluir";
            $params[':excluir'] = $excluirReserva;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function salasDisponiveisNoHorario($idUnidade, $data, $turno)
    {
        $stmt = $this->pdo->prepare(
            "SELECT s.* FROM sala s
             WHERE s.id_unidade = :unidade AND s.status != 'Manutencao'
               AND s.id_sala NOT IN (
                   SELECT r.id_sala FROM reserva r
                   WHERE r.data = :data AND r.turno = :turno AND r.status = 'Ativa'
               )
             ORDER BY s.numero"
        );
        $stmt->execute([':unidade' => $idUnidade, ':data' => $data, ':turno' => $turno]);
        return $stmt->fetchAll();
    }

    public function criar($dados, $usuarioId)
    {
        $conflito = $this->verificarConflito($dados['id_sala'], $dados['data'], $dados['turno']);
        if ($conflito) {
            return ['erro' => 'Conflito: sala ja reservada neste horario'];
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO reserva (id_sala, id_turma, data, turno, observacao, criada_por)
             VALUES (:sala, :turma, :data, :turno, :obs, :usuario)"
        );
        $stmt->execute([
            ':sala'    => $dados['id_sala'],
            ':turma'   => $dados['id_turma'],
            ':data'    => $dados['data'],
            ':turno'   => $dados['turno'],
            ':obs'     => $dados['observacao'] ?? null,
            ':usuario' => $usuarioId
        ]);
        return ['id' => $this->pdo->lastInsertId()];
    }

    public function cancelar($idReserva)
    {
        $stmt = $this->pdo->prepare("UPDATE reserva SET status = 'Cancelada' WHERE id_reserva = :id");
        $stmt->execute([':id' => $idReserva]);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare(
            "SELECT r.*, s.numero AS sala_numero, t.codigo AS turma_codigo
             FROM reserva r
             JOIN sala s ON s.id_sala = r.id_sala
             JOIN turma t ON t.id_turma = r.id_turma
             WHERE r.id_reserva = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function ocupacaoHoje($idUnidade)
    {
        $stmt = $this->pdo->prepare(
            "SELECT s.id_sala, s.numero, s.tipo, s.capacidade, s.status,
                    rm.id_reserva AS reserva_manha, rm_t.codigo AS turma_manha,
                    rt.id_reserva AS reserva_tarde, rt_t.codigo AS turma_tarde,
                    rn.id_reserva AS reserva_noite, rn_t.codigo AS turma_noite
             FROM sala s
             LEFT JOIN reserva rm ON rm.id_sala = s.id_sala AND rm.data = CURDATE() AND rm.turno = 'Manha' AND rm.status = 'Ativa'
             LEFT JOIN turma rm_t ON rm_t.id_turma = rm.id_turma
             LEFT JOIN reserva rt ON rt.id_sala = s.id_sala AND rt.data = CURDATE() AND rt.turno = 'Tarde' AND rt.status = 'Ativa'
             LEFT JOIN turma rt_t ON rt_t.id_turma = rt.id_turma
             LEFT JOIN reserva rn ON rn.id_sala = s.id_sala AND rn.data = CURDATE() AND rn.turno = 'Noite' AND rn.status = 'Ativa'
             LEFT JOIN turma rn_t ON rn_t.id_turma = rn.id_turma
             WHERE s.id_unidade = :unidade
             ORDER BY s.numero"
        );
        $stmt->execute([':unidade' => $idUnidade]);
        return $stmt->fetchAll();
    }

    public function estatisticas($idUnidade, $dataInicio, $dataFim)
    {
        $stmt = $this->pdo->prepare(
            "SELECT
                COUNT(DISTINCT r.id_reserva) AS total_reservas,
                COUNT(DISTINCT r.id_sala) AS salas_utilizadas,
                (SELECT COUNT(*) FROM sala WHERE id_unidade = :unidade2) AS total_salas
             FROM reserva r
             JOIN sala s ON s.id_sala = r.id_sala
             WHERE s.id_unidade = :unidade AND r.data BETWEEN :inicio AND :fim AND r.status = 'Ativa'"
        );
        $stmt->execute([':unidade' => $idUnidade, ':unidade2' => $idUnidade, ':inicio' => $dataInicio, ':fim' => $dataFim]);
        return $stmt->fetch();
    }
}
