<?php require __DIR__ . '/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-person-gear"></i> Usuarios</h2>
    <button class="btn btn-senac" data-bs-toggle="modal" data-bs-target="#modalCadastrar">
        <i class="bi bi-plus-lg"></i> Novo Usuario
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th>Status</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['nome']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><span class="badge bg-info"><?= htmlspecialchars($u['perfil']) ?></span></td>
                <td>
                    <span class="badge <?= $u['ativo'] ? 'bg-success' : 'bg-secondary' ?>">
                        <?= $u['ativo'] ? 'Ativo' : 'Inativo' ?>
                    </span>
                </td>
                <td>
                    <form method="POST" action="index.php?page=usuarios&acao=status" class="d-inline">
                        <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">
                        <input type="hidden" name="ativo" value="<?= $u['ativo'] ? 0 : 1 ?>">
                        <button type="submit" class="btn btn-sm <?= $u['ativo'] ? 'btn-warning' : 'btn-success' ?>">
                            <?= $u['ativo'] ? 'Desativar' : 'Ativar' ?>
                        </button>
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
            <form method="POST" action="index.php?page=usuarios&acao=cadastrar">
                <div class="modal-header" style="background-color: var(--senac-azul); color: white;">
                    <h5 class="modal-title">Novo Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Unidade</label>
                        <select class="form-select" name="id_unidade" required>
                            <?php foreach ($unidades as $un): ?>
                            <option value="<?= $un['id_unidade'] ?>"><?= htmlspecialchars($un['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha (minimo 8 caracteres)</label>
                        <input type="password" class="form-control" name="senha" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Perfil</label>
                        <select class="form-select" name="perfil" required>
                            <option value="Docente">Docente</option>
                            <option value="Suporte">Suporte</option>
                            <option value="Supervisao">Supervisao</option>
                            <option value="Admin">Admin</option>
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
