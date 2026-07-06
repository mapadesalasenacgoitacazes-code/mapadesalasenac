<?php require __DIR__ . '/layout/header.php'; ?>

<h2><i class="bi bi-calendar-check"></i> Nova Reserva</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="index.php?page=reservas&acao=criar">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sala</label>
                    <select class="form-select" name="id_sala" required>
                        <option value="">Selecione a sala...</option>
                        <?php foreach ($salas as $s): ?>
                        <option value="<?= $s['id_sala'] ?>" <?= (($_POST['id_sala'] ?? '') == $s['id_sala']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['numero']) ?> - <?= htmlspecialchars($s['tipo']) ?> (<?= $s['capacidade'] ?> lugares)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Turma</label>
                    <select class="form-select" name="id_turma" required>
                        <option value="">Selecione a turma...</option>
                        <?php foreach ($turmas as $t): ?>
                        <option value="<?= $t['id_turma'] ?>" <?= (($_POST['id_turma'] ?? '') == $t['id_turma']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['codigo']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Data</label>
                    <input type="date" class="form-control" name="data" required value="<?= htmlspecialchars($_POST['data'] ?? '') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Turno</label>
                    <select class="form-select" name="turno" required>
                        <?php foreach (['Manha', 'Tarde', 'Noite'] as $t): ?>
                        <option value="<?= $t ?>" <?= (($_POST['turno'] ?? '') === $t) ? 'selected' : '' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Observacao</label>
                    <input type="text" class="form-control" name="observacao" value="<?= htmlspecialchars($_POST['observacao'] ?? '') ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-senac"><i class="bi bi-check-lg"></i> Reservar</button>
            <a href="index.php?page=painel" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php if (!empty($salasDisponiveis)): ?>
<div class="mt-4">
    <h5>Salas disponiveis nesse horario:</h5>
    <div class="row">
        <?php foreach ($salasDisponiveis as $s): ?>
        <div class="col-md-3 mb-2">
            <div class="card border-success">
                <div class="card-body p-2 text-center">
                    <strong><?= htmlspecialchars($s['numero']) ?></strong><br>
                    <small><?= htmlspecialchars($s['tipo']) ?> - <?= $s['capacidade'] ?> lugares</small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php require __DIR__ . '/layout/footer.php'; ?>
