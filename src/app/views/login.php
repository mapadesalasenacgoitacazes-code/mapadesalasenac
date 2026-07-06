<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mapa de Salas SENAC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #004C94; min-height: 100vh; display: flex; align-items: center; }
        .login-card { max-width: 400px; margin: auto; }
        .btn-senac { background-color: #F7941D; border-color: #F7941D; color: #fff; }
        .btn-senac:hover { background-color: #e0850f; color: #fff; }
    </style>
</head>
<body>
<div class="container">
    <div class="login-card">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="text-center mb-4" style="color: #004C94;">
                    <strong>Mapa de Salas</strong><br>
                    <small class="text-muted">SENAC Minas</small>
                </h3>

                <?php if (!empty($erro)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php?page=login">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-senac w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
