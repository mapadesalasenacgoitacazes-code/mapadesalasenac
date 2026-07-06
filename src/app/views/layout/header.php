<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Salas - SENAC Minas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --senac-azul: #004C94;
            --senac-laranja: #F7941D;
            --senac-laranja-claro: #FDC180;
        }
        .navbar { background-color: var(--senac-azul) !important; }
        .btn-senac { background-color: var(--senac-laranja); border-color: var(--senac-laranja); color: #fff; }
        .btn-senac:hover { background-color: #e0850f; border-color: #e0850f; color: #fff; }
        .sidebar { min-height: calc(100vh - 56px); background-color: #f8f9fa; }
        .sidebar .nav-link { color: #333; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: var(--senac-azul); color: #fff; border-radius: 4px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php?page=painel">
            <i class="bi bi-building"></i> Mapa de Salas SENAC
        </a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3">
                <i class="bi bi-person-circle"></i>
                <?= htmlspecialchars($_SESSION['usuario_nome'] ?? '') ?>
                <span class="badge bg-light text-dark"><?= htmlspecialchars($_SESSION['perfil'] ?? '') ?></span>
            </span>
            <a href="index.php?page=logout" class="btn btn-outline-light btn-sm">Sair</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar py-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'painel' ? 'active' : '' ?>" href="index.php?page=painel">
                        <i class="bi bi-grid-3x3-gap"></i> Painel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'reservas' ? 'active' : '' ?>" href="index.php?page=reservas">
                        <i class="bi bi-calendar-check"></i> Reservas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'salas' ? 'active' : '' ?>" href="index.php?page=salas">
                        <i class="bi bi-door-open"></i> Salas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'turmas' ? 'active' : '' ?>" href="index.php?page=turmas">
                        <i class="bi bi-people"></i> Turmas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'cursos' ? 'active' : '' ?>" href="index.php?page=cursos">
                        <i class="bi bi-book"></i> Cursos
                    </a>
                </li>
                <?php if (in_array($_SESSION['perfil'] ?? '', ['Admin', 'Supervisao'])): ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'usuarios' ? 'active' : '' ?>" href="index.php?page=usuarios">
                        <i class="bi bi-person-gear"></i> Usuarios
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'feriados' ? 'active' : '' ?>" href="index.php?page=feriados">
                        <i class="bi bi-calendar-x"></i> Feriados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'dia-cancelado' ? 'active' : '' ?>" href="index.php?page=dia-cancelado">
                        <i class="bi bi-x-circle"></i> Dias Cancelados
                    </a>
                </li>
                <?php if (in_array($_SESSION['perfil'] ?? '', ['Admin', 'Supervisao'])): ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($page ?? '') === 'log' ? 'active' : '' ?>" href="index.php?page=log">
                        <i class="bi bi-journal-text"></i> Log
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>

        <main class="col-md-10 py-3">
            <?php if (!empty($_GET['msg'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php
                $msgs = [
                    'criada' => 'Registro criado com sucesso!',
                    'criado' => 'Registro criado com sucesso!',
                    'atualizada' => 'Registro atualizado com sucesso!',
                    'atualizado' => 'Registro atualizado com sucesso!',
                    'excluido' => 'Registro excluido com sucesso!',
                    'reserva_criada' => 'Reserva criada com sucesso!',
                    'reserva_cancelada' => 'Reserva cancelada com sucesso!',
                ];
                echo $msgs[$_GET['msg']] ?? 'Operacao realizada com sucesso!';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if (!empty($erro)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($erro) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>
