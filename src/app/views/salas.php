<?php require __DIR__ . '/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-door-open"></i> Salas</h2>
    <button class="btn btn-senac" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
        <i class="bi bi-plus-lg"></i> Nova Sala
    </button>
</div>

<!-- Filtros -->
<form class="row g-2 mb-3" method="GET">
    <input type="hidden" name="page" value="salas">
    <div class="col-auto">
        <select name="tipo" class="form-select form-select-sm">
            <option value="">Todos os Tipos</option>
            <?php foreach (['Sala de Aula', 'Laboratorio', 'Oficina', 'Auditorio'] as $t): ?>
            <option value="<?= $t ?>" <?= ($filtros['tipo'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <select name="andar" class="form-select form-select-sm">
            <option value="">Todos os Andares</option>
            <?php foreach ($andares as $a): ?>
            <option value="<?= htmlspecialchars($a) ?>" <?= ($filtros['andar'] ?? '') === $a ? 'selected' : '' ?>><?= htmlspecialchars($a) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-sm btn-senac">Filtrar</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Numero</th>
                <th>Tipo</th>
                <th>Capacidade</th>
                <th>Andar</th>
                <th>Status</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salas as $sala): ?>
            <tr>
                <td><?= htmlspecialchars($sala['numero']) ?></td>
                <td><?= htmlspecialchars($sala['tipo']) ?></td>
                <td><?= $sala['capacidade'] ?></td>
                <td><?= htmlspecialchars($sala['andar']) ?></td>
                <td>
                    <span class="badge <?= $sala['status'] === 'Ativa' ? 'bg-success' : ($sala['status'] === 'Manutencao' ? 'bg-warning' : 'bg-secondary') ?>">
                        <?= $sala['status'] ?>
                    </span>
                </td>
                <td>
                    <form method="POST" action="index.php?page=salas&acao=status" class="d-inline">
                        <input type="hidden" name="id_sala" value="<?= $sala['id_sala'] ?>">
                        <?php if ($sala['status'] === 'Ativa'): ?>
                        <input type="hidden" name="status" value="Manutencao">
                        <button type="submit" class="btn btn-sm btn-warning">Manutencao</button>
                        <?php else: ?>
                        <input type="hidden" name="status" value="Ativa">
                        <button type="submit" class="btn btn-sm btn-success">Ativar</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Cadastrar -->
<div class="modal fade" id="modalCadastrar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="index.php?page=salas&acao=cadastrar">
                <div class="modal-header" style="background-color: var(--senac-azul); color: white;">
                    <h5 class="modal-title">Nova Sala</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Numero/Nome</label>
                        <input type="text" class="form-control" name="numero" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <select class="form-select" name="tipo" required>
                            <option value="Sala de Aula">Sala de Aula</option>
                            <option value="Laboratorio">Laboratorio</option>
                            <option value="Oficina">Oficina</option>
                            <option value="Auditorio">Auditorio</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Capacidade</label>
                        <input type="number" class="form-control" name="capacidade" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Andar</label>
                        <input type="text" class="form-control" name="andar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observacao</label>
                        <textarea class="form-control" name="observacao" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-senac">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
