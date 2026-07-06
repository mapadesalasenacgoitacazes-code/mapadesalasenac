<?php

class SalaModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function listarPorUnidade($idUnidade, $filtros = [])
    {
        $sql = "SELECT * FROM sala WHERE id_unidade = :unidade";
        $params = [':unidade' => $idUnidade];

        if (!empty($filtros['tipo'])) {
            $sql .= " AND tipo = :tipo";
            $params[':tipo'] = $filtros['tipo'];
        }
        if (!empty($filtros['andar'])) {
            $sql .= " AND andar = :andar";
            $params[':andar'] = $filtros['andar'];
        }
        if (!empty($filtros['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filtros['status'];
        }

        $sql .= " ORDER BY numero";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function listarDisponiveisParaReserva($idUnidade)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM sala WHERE id_unidade = :unidade AND status != 'Manutencao' ORDER BY numero"
        );
        $stmt->execute([':unidade' => $idUnidade]);
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM sala WHERE id_sala = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function criar($dados)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO sala (id_unidade, numero, tipo, capacidade, andar, observacao)
             VALUES (:unidade, :numero, :tipo, :capacidade, :andar, :obs)"
        );
        $stmt->execute([
            ':unidade'    => $dados['id_unidade'],
            ':numero'     => $dados['numero'],
            ':tipo'       => $dados['tipo'],
            ':capacidade' => $dados['capacidade'],
            ':andar'      => $dados['andar'] ?? null,
            ':obs'        => $dados['observacao'] ?? null
        ]);
        return $this->pdo->lastInsertId();
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE sala SET numero = :numero, tipo = :tipo, capacidade = :capacidade,
             andar = :andar, observacao = :obs WHERE id_sala = :id"
        );
        $stmt->execute([
            ':id'         => $id,
            ':numero'     => $dados['numero'],
            ':tipo'       => $dados['tipo'],
            ':capacidade' => $dados['capacidade'],
            ':andar'      => $dados['andar'] ?? null,
            ':obs'        => $dados['observacao'] ?? null
        ]);
    }

    public function alterarStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE sala SET status = :status WHERE id_sala = :id");
        $stmt->execute([':id' => $id, ':status' => $status]);
    }

    public function listarRecursos($idSala)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM recurso_sala WHERE id_sala = :id ORDER BY descricao");
        $stmt->execute([':id' => $idSala]);
        return $stmt->fetchAll();
    }

    public function adicionarRecurso($idSala, $descricao, $quantidade)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO recurso_sala (id_sala, descricao, quantidade) VALUES (:sala, :desc, :qtd)"
        );
        $stmt->execute([':sala' => $idSala, ':desc' => $descricao, ':qtd' => $quantidade]);
    }

    public function removerRecurso($idRecurso)
    {
        $stmt = $this->pdo->prepare("DELETE FROM recurso_sala WHERE id_recurso = :id");
        $stmt->execute([':id' => $idRecurso]);
    }

    public function listarAndares($idUnidade)
    {
        $stmt = $this->pdo->prepare(
            "SELECT DISTINCT andar FROM sala WHERE id_unidade = :unidade AND andar IS NOT NULL ORDER BY andar"
        );
        $stmt->execute([':unidade' => $idUnidade]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
