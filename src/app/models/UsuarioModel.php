<?php

class UsuarioModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function listarTodos($filtros = [])
    {
        $sql = "SELECT u.*, un.nome AS unidade_nome
                FROM usuario u
                JOIN unidade un ON un.id_unidade = u.id_unidade
                WHERE 1=1";
        $params = [];

        if (!empty($filtros['perfil'])) {
            $sql .= " AND u.perfil = :perfil";
            $params[':perfil'] = $filtros['perfil'];
        }
        if (isset($filtros['ativo'])) {
            $sql .= " AND u.ativo = :ativo";
            $params[':ativo'] = $filtros['ativo'];
        }
        if (!empty($filtros['busca'])) {
            $sql .= " AND (u.nome LIKE :busca OR u.email LIKE :busca)";
            $params[':busca'] = '%' . $filtros['busca'] . '%';
        }

        $sql .= " ORDER BY u.nome";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function listarProfessores()
    {
        $stmt = $this->pdo->query(
            "SELECT id_usuario, nome, email, ativo
             FROM usuario WHERE perfil = 'Docente' ORDER BY nome"
        );
        return $stmt->fetchAll();
    }

    public function listarProfessoresAtivos()
    {
        $stmt = $this->pdo->query(
            "SELECT id_usuario, nome, email
             FROM usuario WHERE perfil = 'Docente' AND ativo = TRUE ORDER BY nome"
        );
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE id_usuario = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function buscarPorEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuario WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function criar($dados)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO usuario (id_unidade, nome, email, senha_hash, perfil)
             VALUES (:unidade, :nome, :email, :senha, :perfil)"
        );
        $stmt->execute([
            ':unidade' => $dados['id_unidade'],
            ':nome'    => $dados['nome'],
            ':email'   => $dados['email'],
            ':senha'   => password_hash($dados['senha'], PASSWORD_DEFAULT),
            ':perfil'  => $dados['perfil']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function atualizar($id, $dados)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE usuario SET nome = :nome, email = :email, perfil = :perfil, id_unidade = :unidade
             WHERE id_usuario = :id"
        );
        $stmt->execute([
            ':id'      => $id,
            ':nome'    => $dados['nome'],
            ':email'   => $dados['email'],
            ':perfil'  => $dados['perfil'],
            ':unidade' => $dados['id_unidade']
        ]);
    }

    public function alterarSenha($id, $novaSenha)
    {
        $stmt = $this->pdo->prepare("UPDATE usuario SET senha_hash = :senha WHERE id_usuario = :id");
        $stmt->execute([':id' => $id, ':senha' => password_hash($novaSenha, PASSWORD_DEFAULT)]);
    }

    public function alterarStatus($id, $ativo)
    {
        $stmt = $this->pdo->prepare("UPDATE usuario SET ativo = :ativo WHERE id_usuario = :id");
        $stmt->execute([':id' => $id, ':ativo' => $ativo]);
    }
}
