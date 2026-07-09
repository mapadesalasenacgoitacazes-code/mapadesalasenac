<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Turmas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fc;
            font-family: Arial, sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #0a2540;
            color: #fff;
        }

        .sidebar a {
            color: #a3b8cc;
            display: block;
            padding: 12px 18px;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }

        .content {
            margin-left: 240px;
            padding: 25px;
        }

        /* CARDS */
        .card-box {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 18px;
        }

        /* TABLE */
        .table thead {
            background: #0d47a1;
            color: #fff;
        }

        /* TIMELINE */
        .timeline {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .bar {
            height: 26px;
            border-radius: 6px;
            color: #fff;
            font-size: 12px;
            display: flex;
            align-items: center;
            padding-left: 10px;
            margin-bottom: 10px;
        }

        .green {
            background: #4caf50;
        }

        .orange {
            background: #ff9800;
        }

        .purple {
            background: #7e57c2;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar p-3">
        <h5 class="badge bg-primary fs-5 px-3 py-2">MS</h5>

        <a href="mapa-painel.php"><i class="bi bi-house"></i> Painel</a>
        <a href="#"><i class="bi bi-door-open"></i> Salas</a>
        <a href="#"><i class="bi bi-people"></i> Turmas</a>
        <a href="#"><i class="bi bi-calendar"></i> Reservas</a>
        <a class="active" href="mapa-relatorio.php"><i class="bi bi-bar-chart"></i> Relatórios</a>

        <div class="mt-4">
            <a href="#" class="text-danger"><i class="bi bi-box-arrow-left"></i> Sair</a>
        </div>
    </div>

    <!-- CONTEÚDO -->
    <div class="content">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Relatório de Turmas</h3>
                <small class="text-muted">Veja o histórico de utilização das salas</small>
            </div>

            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-bell fs-5"></i>
                <div class="text-end">
                    <strong>Maria Silva</strong><br>
                    <small>Supervisão</small>
                </div>
            </div>
        </div>

        <!-- CARDS -->
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card-box">
                    <div class="icon bg-primary text-white"><i class="bi bi-building"></i></div>
                    <div>
                        <strong>3</strong><br>
                        <small>Salas utilizadas</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-box">
                    <div class="icon bg-success text-white"><i class="bi bi-calendar"></i></div>
                    <div>
                        <small>Período analisado</small><br>
                        <strong>25/05 - 01/07</strong>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-box">
                    <div class="icon bg-warning text-white"><i class="bi bi-clock"></i></div>
                    <div>
                        <strong>23 dias</strong><br>
                        <small>Total de uso</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-box">
                    <div class="icon bg-info text-white"><i class="bi bi-people"></i></div>
                    <div>
                        <strong>3</strong><br>
                        <small>Turmas diferentes</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- TABELA -->
        <div class="bg-white p-3 rounded mb-4">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Sala</th>
                        <th>Tipo</th>
                        <th>Primeira vez</th>
                        <th>Última vez</th>
                        <th>Total</th>
                        <th>Turno</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>🍳 Cozinha Industrial</td>
                        <td>Cozinha</td>
                        <td>25/05/2026</td>
                        <td>29/06/2026</td>
                        <td>12 dias</td>
                        <td><span class="badge bg-warning text-dark">Manhã</span></td>
                    </tr>

                    <tr>
                        <td>🖥 Sala 4</td>
                        <td>Sala de Aula</td>
                        <td>27/05/2026</td>
                        <td>01/07/2026</td>
                        <td>8 dias</td>
                        <td><span class="badge bg-warning">Tarde</span></td>
                    </tr>

                    <tr>
                        <td>⚗ Lab 2</td>
                        <td>Laboratório</td>
                        <td>15/06/2026</td>
                        <td>22/06/2026</td>
                        <td>3 dias</td>
                        <td><span class="badge bg-warning">Tarde</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- TIMELINE -->
        <div class="timeline">

            <h5 class="mb-3">Linha do tempo</h5>

            <div class="bar green" style="width: 85%;">Cozinha (manhã)</div>
            <div class="bar orange" style="width: 90%;">Sala 4 (tarde)</div>
            <div class="bar purple" style="width: 40%;">Lab 2 (tarde)</div>

        </div>

    </div>

</body>

</html>