<?php require __DIR__ . '/layout/header.php'; ?>

<h2><i class="bi bi-search"></i> Disponibilidade de Salas</h2>

<form class="row g-2 mb-4" method="GET">
    <input type="hidden" name="page" value="reservas">
    <input type="hidden" name="acao" value="disponibilidade">
    <div class="col-auto">
        <input type="date" class="form-control" name="data" value="<?= htmlspecialchars($data) ?>">
    </div>
    <div class="col-auto">
        <select class="form-select" name="turno">
            <?php foreach (['Manha', 'Tarde', 'Noite'] as $t): ?>
            <option value="<?= $t ?>" <?= $turno === $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-senac">Consultar</button>
    </div>
</form>

<h5><?= count($salasDisponiveis) ?> sala(s) disponivel(is) em <?= date('d/m/Y', strtotime($data)) ?> - <?= $turno ?></h5>

<div class="row">
    <?php foreach ($salasDisponiveis as $s): ?>
    <div class="col-md-3 mb-3">
        <div class="card border-success h-100">
            <div class="card-body text-center">
                <h5 class="card-title"><?= htmlspecialchars($s['numero']) ?></h5>
                <p class="card-text">
                    <?= htmlspecialchars($s['tipo']) ?><br>
                    <i class="bi bi-people"></i> <?= $s['capacidade'] ?> lugares<br>
                    <?php if ($s['andar']): ?>
                    <i class="bi bi-layers"></i> <?= htmlspecialchars($s['andar']) ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
