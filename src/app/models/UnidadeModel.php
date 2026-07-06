<?php

class UnidadeModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function listarTodas()
    {
        return $this->pdo->query("SELECT * FROM unidade ORDER BY nome")->fetchAll();
    }

    public function listarAtivas()
    {
        return $this->pdo->query("SELECT * FROM unidade WHERE ativo = TRUE ORDER BY nome")->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM unidade WHERE id_unidade = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function criar($dados)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO unidade (nome, cidade, estado, endereco)
             VALUES (:nome, :cidade, :estado, :endereco)"
        );
        $stmt->execute([
            ':nome'     => $dados['nome'],
            ':cidade'   => $dados['cidade'],
            ':estado'   => $dados['estado'] ?? 'MG',
            ':endereco' => $dados['endereco'] ?? null
        ]);
        return $this->pdo->lastInsertId();
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE unidade SET nome = :nome, cidade = :cidade, estado = :estado, endereco = :endereco
             WHERE id_unidade = :id"
        );
        $stmt->execute([
            ':id'       => $id,
            ':nome'     => $dados['nome'],
            ':cidade'   => $dados['cidade'],
            ':estado'   => $dados['estado'],
            ':endereco' => $dados['endereco'] ?? null
        ]);
    }

    public function alterarStatus($id, $ativo)
    {
        $stmt = $this->pdo->prepare("UPDATE unidade SET ativo = :ativo WHERE id_unidade = :id");
        $stmt->execute([':id' => $id, ':ativo' => $ativo]);
    }
}
