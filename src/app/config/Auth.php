<?php

class Auth
{
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login($email, $senha)
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email = :email AND ativo = TRUE");
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            $_SESSION['usuario_id']   = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['perfil']       = $usuario['perfil'];
            $_SESSION['id_unidade']   = $usuario['id_unidade'];
            session_regenerate_id(true);
            return true;
        }
        return false;
    }

    public static function logout()
    {
        session_destroy();
        header('Location: index.php');
        exit;
    }

    public static function verificarLogin()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }

    public static function verificarPerfil($perfisPermitidos)
    {
        if (!in_array($_SESSION['perfil'], $perfisPermitidos)) {
            header('Location: index.php?page=painel&erro=sem_permissao');
            exit;
        }
    }

    public static function gerarTokenCSRF()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validarTokenCSRF($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
