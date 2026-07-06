<?php require __DIR__ . '/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-people"></i> Turmas</h2>
    <button class="btn btn-senac" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
        <i class="bi bi-plus-lg"></i> Nova Turma
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Codigo</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Inicio</th>
                <th>Termino Previsto</th>
                <th>Professores</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($turmas as $turma): ?>
            <tr>
                <td><?= htmlspecialchars($turma['codigo']) ?></td>
                <td><?= htmlspecialchars($turma['curso_nome'] ?? '') ?></td>
                <td><?= htmlspecialchars($turma['turno']) ?></td>
                <td><?= date('d/m/Y', strtotime($turma['data_inicio'])) ?></td>
                <td><?= date('d/m/Y', strtotime($turma['data_termino_prevista'])) ?></td>
                <td><?= htmlspecialchars($turma['professores'] ?? '-') ?></td>
                <td>
                    <span class="badge <?= $turma['ativa'] ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $turma['ativa'] ? 'Ativa' : 'Inativa' ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Cadastrar -->
<div class="modal fade" id="modalCadastrar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="index.php?page=turmas&acao=cadastrar">
                <div class="modal-header" style="background-color: var(--senac-azul); color: white;">
                    <h5 class="modal-title">Nova Turma</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Codigo</label>
                            <input type="text" class="form-control" name="codigo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Curso</label>
                            <select class="form-select" name="id_curso" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($cursos as $c): ?>
                                <option value="<?= $c['id_curso'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Turno</label>
                            <select class="form-select" name="turno" required>
                                <option value="Manha">Manha</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noite">Noite</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Data Inicio</label>
                            <input type="date" class="form-control" name="data_inicio" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Termino Previsto</label>
                            <input type="date" class="form-control" name="data_termino_prevista" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dias da Semana</label>
                        <div class="d-flex gap-3">
                            <?php foreach (['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'] as $d): ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="dias_semana[]" value="<?= $d ?>" id="dia_<?= $d ?>">
                                <label class="form-check-label" for="dia_<?= $d ?>"><?= $d ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Professores</label>
                        <select class="form-select" name="professores[]" multiple size="4">
                            <?php foreach ($professores as $p): ?>
                            <option value="<?= $p['id_usuario'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Segure Ctrl para selecionar varios</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Professor Principal</label>
                        <select class="form-select" name="professor_principal">
                            <option value="">Selecione...</option>
                            <?php foreach ($professores as $p): ?>
                            <option value="<?= $p['id_usuario'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
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
