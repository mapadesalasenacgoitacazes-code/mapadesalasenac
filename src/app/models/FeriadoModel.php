<?php

class FeriadoModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function listarPorUnidade($idUnidade, $ano = null)
    {
        $sql = "SELECT * FROM feriado WHERE id_unidade = :unidade";
        $params = [':unidade' => $idUnidade];

        if ($ano) {
            $sql .= " AND YEAR(data) = :ano";
            $params[':ano'] = $ano;
        }

        $sql .= " ORDER BY data";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM feriado WHERE id_feriado = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function criar($dados)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO feriado (id_unidade, data, descricao, tipo)
             VALUES (:unidade, :data, :desc, :tipo)"
        );
        $stmt->execute([
            ':unidade' => $dados['id_unidade'],
            ':data'    => $dados['data'],
            ':desc'    => $dados['descricao'],
            ':tipo'    => $dados['tipo']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE feriado SET data = :data, descricao = :desc, tipo = :tipo WHERE id_feriado = :id"
        );
        $stmt->execute([
            ':id'   => $id,
            ':data' => $dados['data'],
            ':desc' => $dados['descricao'],
            ':tipo' => $dados['tipo']
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM feriado WHERE id_feriado = :id");
        $stmt->execute([':id' => $id]);
    }

    public function verificarFeriado($idUnidade, $data)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM feriado WHERE id_unidade = :unidade AND data = :data"
        );
        $stmt->execute([':unidade' => $idUnidade, ':data' => $data]);
        return $stmt->fetch();
    }
}
