<?php require __DIR__ . '/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-x-circle"></i> Dias Cancelados</h2>
    <button class="btn btn-senac" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
        <i class="bi bi-plus-lg"></i> Registrar Dia Cancelado
    </button>
</div>

<form class="row g-2 mb-3" method="GET">
    <input type="hidden" name="page" value="dia-cancelado">
    <div class="col-auto">
        <select class="form-select" name="id_turma" onchange="this.form.submit()">
            <option value="">Selecione a turma...</option>
            <?php foreach ($turmas as $t): ?>
            <option value="<?= $t['id_turma'] ?>" <?= ($_GET['id_turma'] ?? '') == $t['id_turma'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($t['codigo']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

<?php if (!empty($diasCancelados)): ?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Data</th>
                <th>Motivo</th>
                <th>Registrado por</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($diasCancelados as $d): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($d['data'])) ?></td>
                <td><?= htmlspecialchars($d['motivo']) ?></td>
                <td><?= htmlspecialchars($d['registrado_por_nome'] ?? '-') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php elseif (!empty($_GET['id_turma'])): ?>
<div class="alert alert-info">Nenhum dia cancelado registrado para esta turma.</div>
<?php endif; ?>

<!-- Modal Cadastrar -->
<div class="modal fade" id="modalCadastrar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="index.php?page=dia-cancelado&acao=cadastrar">
                <div class="modal-header" style="background-color: var(--senac-azul); color: white;">
                    <h5 class="modal-title">Registrar Dia Cancelado</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Turma</label>
                        <select class="form-select" name="id_turma" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($turmas as $t): ?>
                            <option value="<?= $t['id_turma'] ?>"><?= htmlspecialchars($t['codigo']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data</label>
                        <input type="date" class="form-control" name="data" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <input type="text" class="form-control" name="motivo" required>
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
