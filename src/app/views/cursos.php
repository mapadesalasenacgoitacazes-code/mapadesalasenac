<?php require __DIR__ . '/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-book"></i> Cursos</h2>
    <button class="btn btn-senac" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
        <i class="bi bi-plus-lg"></i> Novo Curso
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Area</th>
                <th>Programa</th>
                <th>Carga Horaria</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cursos as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['tipo_curso']) ?></td>
                <td><?= htmlspecialchars($c['area']) ?></td>
                <td><?= htmlspecialchars($c['programa']) ?></td>
                <td><?= $c['carga_horaria_total'] ?>h</td>
                <td>
                    <span class="badge <?= $c['ativo'] ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $c['ativo'] ? 'Ativo' : 'Inativo' ?>
                    </span>
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
            <form method="POST" action="index.php?page=cursos&acao=cadastrar">
                <div class="modal-header" style="background-color: var(--senac-azul); color: white;">
                    <h5 class="modal-title">Novo Curso</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo</label>
                        <select class="form-select" name="tipo_curso" required>
                            <option value="Tecnico">Tecnico</option>
                            <option value="Aprendizagem">Aprendizagem</option>
                            <option value="Qualificacao">Qualificacao</option>
                            <option value="Extensao">Extensao</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <input type="text" class="form-control" name="area" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Programa</label>
                        <select class="form-select" name="programa">
                            <option value="Todos">Todos</option>
                            <option value="PSG">PSG</option>
                            <option value="MEDIOTEC">MEDIOTEC</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Carga Horaria Total (horas)</label>
                        <input type="number" class="form-control" name="carga_horaria_total" required min="1">
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
