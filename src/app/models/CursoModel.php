<?php

class CursoModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function listarTodos($filtros = [])
    {
        $sql = "SELECT * FROM curso WHERE 1=1";
        $params = [];

        if (!empty($filtros['tipo_curso'])) {
            $sql .= " AND tipo_curso = :tipo";
            $params[':tipo'] = $filtros['tipo_curso'];
        }
        if (!empty($filtros['area'])) {
            $sql .= " AND area = :area";
            $params[':area'] = $filtros['area'];
        }
        if (!empty($filtros['programa'])) {
            $sql .= " AND programa = :programa";
            $params[':programa'] = $filtros['programa'];
        }
        if (isset($filtros['ativo'])) {
            $sql .= " AND ativo = :ativo";
            $params[':ativo'] = $filtros['ativo'];
        }

        $sql .= " ORDER BY nome";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function listarAtivos()
    {
        return $this->pdo->query("SELECT * FROM curso WHERE ativo = TRUE ORDER BY nome")->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM curso WHERE id_curso = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function criar($dados)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO curso (nome, tipo_curso, area, programa, carga_horaria_total)
             VALUES (:nome, :tipo, :area, :programa, :ch)"
        );
        $stmt->execute([
            ':nome'     => $dados['nome'],
            ':tipo'     => $dados['tipo_curso'],
            ':area'     => $dados['area'],
            ':programa' => $dados['programa'] ?? 'Todos',
            ':ch'       => $dados['carga_horaria_total']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE curso SET nome = :nome, tipo_curso = :tipo, area = :area,
             programa = :programa, carga_horaria_total = :ch WHERE id_curso = :id"
        );
        $stmt->execute([
            ':id'       => $id,
            ':nome'     => $dados['nome'],
            ':tipo'     => $dados['tipo_curso'],
            ':area'     => $dados['area'],
            ':programa' => $dados['programa'],
            ':ch'       => $dados['carga_horaria_total']
        ]);
    }

    public function alterarStatus($id, $ativo)
    {
        $stmt = $this->pdo->prepare("UPDATE curso SET ativo = :ativo WHERE id_curso = :id");
        $stmt->execute([':id' => $id, ':ativo' => $ativo]);
    }
}
