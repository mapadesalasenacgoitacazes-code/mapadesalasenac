<?php

class LogModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function registrar($usuarioId, $acao, $tabela, $idRegistro, $descricao)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO log_alteracao (id_usuario, acao, tabela_afetada, id_registro, descricao)
             VALUES (:usuario, :acao, :tabela, :registro, :desc)"
        );
        $stmt->execute([
            ':usuario'  => $usuarioId,
            ':acao'     => $acao,
            ':tabela'   => $tabela,
            ':registro' => $idRegistro,
            ':desc'     => $descricao
        ]);
    }

    public function listar($filtros = [], $limite = 50, $offset = 0)
    {
        $sql = "SELECT l.*, u.nome AS usuario_nome
                FROM log_alteracao l
                JOIN usuario u ON u.id_usuario = l.id_usuario
                WHERE 1=1";
        $params = [];

        if (!empty($filtros['tabela'])) {
            $sql .= " AND l.tabela_afetada = :tabela";
            $params[':tabela'] = $filtros['tabela'];
        }
        if (!empty($filtros['acao'])) {
            $sql .= " AND l.acao = :acao";
            $params[':acao'] = $filtros['acao'];
        }
        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND l.data_hora >= :inicio";
            $params[':inicio'] = $filtros['data_inicio'] . ' 00:00:00';
        }
        if (!empty($filtros['data_fim'])) {
            $sql .= " AND l.data_hora <= :fim";
            $params[':fim'] = $filtros['data_fim'] . ' 23:59:59';
        }
        if (!empty($filtros['busca'])) {
            $sql .= " AND (l.descricao LIKE :busca OR u.nome LIKE :busca)";
            $params[':busca'] = '%' . $filtros['busca'] . '%';
        }

        $sql .= " ORDER BY l.data_hora DESC LIMIT $limite OFFSET $offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function contarTotal($filtros = [])
    {
        $sql = "SELECT COUNT(*) FROM log_alteracao l
                JOIN usuario u ON u.id_usuario = l.id_usuario WHERE 1=1";
        $params = [];

        if (!empty($filtros['tabela'])) {
            $sql .= " AND l.tabela_afetada = :tabela";
            $params[':tabela'] = $filtros['tabela'];
        }
        if (!empty($filtros['acao'])) {
            $sql .= " AND l.acao = :acao";
            $params[':acao'] = $filtros['acao'];
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
}
