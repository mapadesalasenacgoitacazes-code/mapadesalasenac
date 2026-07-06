<?php require __DIR__ . '/layout/header.php'; ?>

<h2><i class="bi bi-grid-3x3-gap"></i> Painel de Reservas</h2>

<!-- Navegacao de semana -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="index.php?page=painel&inicio=<?= date('Y-m-d', strtotime($inicioSemana . ' -7 days')) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-chevron-left"></i> Semana Anterior
    </a>
    <h5 class="mb-0">
        <?= date('d/m', strtotime($inicioSemana)) ?> a <?= date('d/m/Y', strtotime($fimSemana)) ?>
    </h5>
    <a href="index.php?page=painel&inicio=<?= date('Y-m-d', strtotime($inicioSemana . ' +7 days')) ?>" class="btn btn-outline-secondary">
        Proxima Semana <i class="bi bi-chevron-right"></i>
    </a>
</div>

<!-- Filtros -->
<form class="row g-2 mb-3" method="GET">
    <input type="hidden" name="page" value="painel">
    <input type="hidden" name="inicio" value="<?= htmlspecialchars($inicioSemana) ?>">
    <div class="col-auto">
        <select name="turno" class="form-select form-select-sm">
            <option value="">Todos os Turnos</option>
            <?php foreach (['Manha', 'Tarde', 'Noite'] as $t): ?>
            <option value="<?= $t ?>" <?= ($filtros['turno'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <select name="tipo_sala" class="form-select form-select-sm">
            <option value="">Todos os Tipos</option>
            <?php foreach (['Sala de Aula', 'Laboratorio', 'Oficina', 'Auditorio'] as $t): ?>
            <option value="<?= $t ?>" <?= ($filtros['tipo_sala'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
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

<!-- Mapa semanal -->
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead class="table-dark">
            <tr>
                <th>Sala</th>
                <?php
                $diasSemana = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'];
                for ($i = 0; $i < 6; $i++):
                    $diaAtual = date('Y-m-d', strtotime($inicioSemana . " +$i days"));
                ?>
                <th class="text-center"><?= $diasSemana[$i] ?> <?= date('d/m', strtotime($diaAtual)) ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($salas as $sala): ?>
            <tr>
                <td><strong><?= htmlspecialchars($sala['numero']) ?></strong><br><small class="text-muted"><?= htmlspecialchars($sala['tipo']) ?></small></td>
                <?php for ($i = 0; $i < 6; $i++):
                    $diaAtual = date('Y-m-d', strtotime($inicioSemana . " +$i days"));
                    $reservasDia = array_filter($reservas, function($r) use ($sala, $diaAtual) {
                        return $r['id_sala'] == $sala['id_sala'] && $r['data'] === $diaAtual;
                    });
                ?>
                <td class="text-center small">
                    <?php if (empty($reservasDia)): ?>
                        <span class="text-success">Livre</span>
                    <?php else: ?>
                        <?php foreach ($reservasDia as $r): ?>
                        <span class="badge bg-primary"><?= $r['turno'][0] ?>: <?= htmlspecialchars($r['turma_codigo']) ?></span><br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
                <?php endfor; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Ocupacao de hoje -->
<h4 class="mt-4">Ocupacao Hoje (<?= date('d/m/Y') ?>)</h4>
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Sala</th>
                <th class="text-center">Manha</th>
                <th class="text-center">Tarde</th>
                <th class="text-center">Noite</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ocupacaoHoje as $o): ?>
            <tr>
                <td><?= htmlspecialchars($o['numero']) ?></td>
                <td class="text-center <?= $o['reserva_manha'] ? 'table-warning' : 'table-success' ?>">
                    <?= $o['turma_manha'] ? htmlspecialchars($o['turma_manha']) : 'Livre' ?>
                </td>
                <td class="text-center <?= $o['reserva_tarde'] ? 'table-warning' : 'table-success' ?>">
                    <?= $o['turma_tarde'] ? htmlspecialchars($o['turma_tarde']) : 'Livre' ?>
                </td>
                <td class="text-center <?= $o['reserva_noite'] ? 'table-warning' : 'table-success' ?>">
                    <?= $o['turma_noite'] ? htmlspecialchars($o['turma_noite']) : 'Livre' ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
