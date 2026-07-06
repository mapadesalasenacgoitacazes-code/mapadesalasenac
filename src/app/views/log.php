<?php require __DIR__ . '/layout/header.php'; ?>

<h2><i class="bi bi-journal-text"></i> Log de Alteracoes</h2>

<form class="row g-2 mb-3" method="GET">
    <input type="hidden" name="page" value="log">
    <div class="col-auto">
        <select class="form-select form-select-sm" name="tabela">
            <option value="">Todas as Tabelas</option>
            <?php foreach (['usuario', 'sala', 'curso', 'turma', 'reserva', 'feriado', 'dia_cancelado'] as $t): ?>
            <option value="<?= $t ?>" <?= ($filtros['tabela'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <select class="form-select form-select-sm" name="acao">
            <option value="">Todas as Acoes</option>
            <?php foreach (['Criacao', 'Edicao', 'Exclusao', 'Cancelamento'] as $a): ?>
            <option value="<?= $a ?>" <?= ($filtros['acao'] ?? '') === $a ? 'selected' : '' ?>><?= $a ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <input type="date" class="form-control form-control-sm" name="data_inicio" value="<?= htmlspecialchars($filtros['data_inicio'] ?? '') ?>" placeholder="Data inicio">
    </div>
    <div class="col-auto">
        <input type="date" class="form-control form-control-sm" name="data_fim" value="<?= htmlspecialchars($filtros['data_fim'] ?? '') ?>" placeholder="Data fim">
    </div>
    <div class="col-auto">
        <input type="text" class="form-control form-control-sm" name="busca" value="<?= htmlspecialchars($filtros['busca'] ?? '') ?>" placeholder="Buscar...">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-sm btn-senac">Filtrar</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr>
                <th>Data/Hora</th>
                <th>Usuario</th>
                <th>Acao</th>
                <th>Tabela</th>
                <th>Descricao</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $l): ?>
            <tr>
                <td><?= date('d/m/Y H:i', strtotime($l['data_hora'])) ?></td>
                <td><?= htmlspecialchars($l['usuario_nome']) ?></td>
                <td><span class="badge bg-secondary"><?= htmlspecialchars($l['acao']) ?></span></td>
                <td><?= htmlspecialchars($l['tabela_afetada']) ?></td>
                <td><?= htmlspecialchars($l['descricao']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Paginacao -->
<?php if ($totalPaginas > 1): ?>
<nav>
    <ul class="pagination pagination-sm">
        <?php for ($p = 1; $p <= $totalPaginas; $p++): ?>
        <li class="page-item <?= $p == $pagina ? 'active' : '' ?>">
            <a class="page-link" href="index.php?page=log&pagina=<?= $p ?>&tabela=<?= urlencode($filtros['tabela'] ?? '') ?>&acao=<?= urlencode($filtros['acao'] ?? '') ?>"><?= $p ?></a>
        </li>
        <?php endfor; ?>
    </ul>
</nav>
<?php endif; ?>

<?php require __DIR__ . '/layout/footer.php'; ?>
