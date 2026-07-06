<?php require __DIR__ . '/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-calendar-x"></i> Feriados e Recessos</h2>
    <button class="btn btn-senac" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
        <i class="bi bi-plus-lg"></i> Novo Feriado
    </button>
</div>

<form class="row g-2 mb-3" method="GET">
    <input type="hidden" name="page" value="feriados">
    <div class="col-auto">
        <select class="form-select form-select-sm" name="ano">
            <?php for ($a = date('Y') - 1; $a <= date('Y') + 1; $a++): ?>
            <option value="<?= $a ?>" <?= $ano == $a ? 'selected' : '' ?>><?= $a ?></option>
            <?php endfor; ?>
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
                <th>Data</th>
                <th>Descricao</th>
                <th>Tipo</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($feriados as $f): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($f['data'])) ?></td>
                <td><?= htmlspecialchars($f['descricao']) ?></td>
                <td><span class="badge bg-info"><?= htmlspecialchars($f['tipo']) ?></span></td>
                <td>
                    <form method="POST" action="index.php?page=feriados&acao=excluir" class="d-inline"
                          onsubmit="return confirm('Tem certeza que deseja excluir?')">
                        <input type="hidden" name="id_feriado" value="<?= $f['id_feriado'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
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
            <form method="POST" action="index.php?page=feriados&acao=cadastrar">
                <div class="modal-header" style="background-color: var(--senac-azul); color: white;">
                    <h5 class="modal-title">Novo Feriado/Recesso</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Data</label>
                        <input type="date" class="form-control" name="data" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descricao</label>
                        <input type="text" class="form-control" name="descricao" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <select class="form-select" name="tipo" required>
                            <option value="Feriado Nacional">Feriado Nacional</option>
                            <option value="Feriado Estadual">Feriado Estadual</option>
                            <option value="Feriado Municipal">Feriado Municipal</option>
                            <option value="Recesso">Recesso</option>
                            <option value="Ponto Facultativo">Ponto Facultativo</option>
                        </select>
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
