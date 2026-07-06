<?php

class DiaCanceladoModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function listarPorTurma($idTurma)
    {
        $stmt = $this->pdo->prepare(
            "SELECT dc.*, u.nome AS registrado_por_nome
             FROM dia_cancelado dc
             LEFT JOIN usuario u ON u.id_usuario = dc.registrado_por
             WHERE dc.id_turma = :turma ORDER BY dc.data"
        );
        $stmt->execute([':turma' => $idTurma]);
        return $stmt->fetchAll();
    }

    public function criar($dados, $usuarioId)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO dia_cancelado (id_turma, data, motivo, registrado_por)
             VALUES (:turma, :data, :motivo, :usuario)"
        );
        $stmt->execute([
            ':turma'   => $dados['id_turma'],
            ':data'    => $dados['data'],
            ':motivo'  => $dados['motivo'],
            ':usuario' => $usuarioId
        ]);

        $turmaModel = new TurmaModel();
        $turmaModel->atualizarDataTerminoCalculada($dados['id_turma']);

        return $this->pdo->lastInsertId();
    }

    public function excluir($id)
    {
        $stmt = $this->pdo->prepare("SELECT id_turma FROM dia_cancelado WHERE id_cancelamento = :id");
        $stmt->execute([':id' => $id]);
        $idTurma = $stmt->fetchColumn();

        $stmt = $this->pdo->prepare("DELETE FROM dia_cancelado WHERE id_cancelamento = :id");
        $stmt->execute([':id' => $id]);

        if ($idTurma) {
            $turmaModel = new TurmaModel();
            $turmaModel->atualizarDataTerminoCalculada($idTurma);
        }
    }
}
