<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Mapa de Salinhas</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* --- ESTILOS GERAIS E PALETA DE CORES --- */
        :root {
            --cor-fundo-sistema: #f4f7fc;
            --cor-menu-lateral: #0a2540;
            --cor-texto-menu: #a3b8cc;
            --cor-azul-primario: #0052cc;

            /* Cores dos Cards de Status */
            --status-cadastradas: #e6f0ff;
            --status-disponiveis: #e6f4ea;
            --status-ocupadas: #fef3e6;
            --status-manutencao: #fce8e6;

            /* Cores das Reservas (Legenda) */
            --reserva-manha: #fff9db;
            --texto-manha: #f59f00;
            --reserva-tarde: #fff0f6;
            --texto-tarde: #d6336c;
            --reserva-noite: #edf2ff;
            --texto-noite: #3b5bdb;
            --reserva-gastronomia: #ebfbee;
            --texto-gastronomia: #2b8a3e;
            --reserva-manutencao: #fff5f5;
            --texto-manutencao: #fa5252;
        }

        body {
            background-color: var(--cor-fundo-sistema);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* --- MENU LATERAL (SIDEBAR) --- */
        .menu-lateral {
            background-color: var(--cor-menu-lateral);
            min-height: 100vh;
            color: var(--cor-texto-menu);
            width: 240px;
            position: fixed;
        }

        .menu-lateral .logo-container {
            background-color: #001529;
            padding: 20px;
            text-align: center;
        }

        .menu-lateral .nav-link {
            color: var(--cor-texto-menu);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid transparent;
            transition: all 0.2s;
        }

        .menu-lateral .nav-link:hover,
        .menu-lateral .nav-link.ativo {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
            border-left-color: var(--cor-azul-primario);
        }

        /* --- CONTEÚDO PRINCIPAL --- */
        .conteudo-principal {
            margin-left: 240px;
            padding: 30px;
        }

        /* --- CARDS DE RESUMO --- */
        .card-contador {
            border: none;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .card-contador .icone-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* Variações dos Cards */
        .card-cadastradas {
            background-color: #ffffff;
        }

        .card-cadastradas .icone-wrapper {
            background-color: var(--status-cadastradas);
            color: #0052cc;
        }

        .card-disponiveis {
            background-color: #ffffff;
        }

        .card-disponiveis .icone-wrapper {
            background-color: var(--status-disponiveis);
            color: #1e7e34;
        }

        .card-ocupadas {
            background-color: #ffffff;
        }

        .card-ocupadas .icone-wrapper {
            background-color: var(--status-ocupadas);
            color: #fd7e14;
        }

        .card-manutencao {
            background-color: #ffffff;
        }

        .card-manutencao .icone-wrapper {
            background-color: var(--status-manutencao);
            color: #dc3545;
        }

        /* --- SEÇÃO DE FILTROS --- */
        .container-filtros {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        /* --- TABELA DE HORÁRIOS / CRONOGRAMA --- */
        .tabela-cronograma {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .tabela-cronograma th {
            background-color: #004085;
            color: #ffffff;
            text-align: center;
            font-size: 12px;
            text-transform: uppercase;
            padding: 15px;
            border: 1px solid #003366;
            vertical-align: middle;
        }

        .tabela-cronograma td {
            border: 1px solid #e9ecef;
            vertical-align: top;
            padding: 12px;
            width: 16.66%;
        }
    </style>
</head>

<body>

    <!-- MENU LATERAL -->
    <div class="menu-lateral d-flex flex-column justify-content-between pb-4">
        <div>
            <div class="logo-container mb-4">
                <span class="badge bg-primary fs-5 px-3 py-2">MS</span>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link" href="#"><i class="bi bi-grid-1x2-fill"></i> Painel</a>
                <a class="nav-link ativo" href="#"><i class="bi bi-door-open"></i> Salas</a>
                <a class="nav-link" href="#"><i class="bi bi-people"></i> Turmas</a>
                <a class="nav-link" href="#"><i class="bi bi-calendar-event"></i> Reservas</a>
                <a class="nav-link" href="#"><i class="bi bi-bar-chart-line"></i> Relatórios</a>
            </nav>
        </div>

        <div>
            <a class="nav-link text-danger" href="#">
                <i class="bi bi-box-arrow-left"></i> Sair
            </a>
        </div>
    </div>

    <!-- CONTEÚDO PRINCIPAL -->
    <div class="conteudo-principal">

        <!-- CABEÇALHO SUPERIOR -->
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark m-0">Mapa de Salas</h4>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light position-relative rounded-circle p-2">
                    <i class="bi bi-bell fs-5"></i>
                </button>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-circle p-2">MS</span>

                    <div class="text-end lh-1">
                        <small class="fw-bold d-block text-dark">Maria Silva</small>
                        <small class="text-muted" style="font-size: 11px;">
                            Supervisão <i class="bi bi-chevron-down"></i>
                        </small>
                    </div>
                </div>
            </div>
        </header>

        <!-- DASHBOARD DE CARDS -->
        <section class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card-contador card-cadastradas">
                    <div class="icone-wrapper"><i class="bi bi-building"></i></div>
                    <div>
                        <h3 class="fw-bold m-0 text-dark">24</h3>
                        <small class="text-muted">Salas cadastradas</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-contador card-disponiveis">
                    <div class="icone-wrapper"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <h3 class="fw-bold m-0 text-dark">18</h3>
                        <small class="text-muted">Disponíveis hoje</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-contador card-ocupadas">
                    <div class="icone-wrapper"><i class="bi bi-people"></i></div>
                    <div>
                        <h3 class="fw-bold m-0 text-dark">5</h3>
                        <small class="text-muted">Ocupadas agora</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-contador card-manutencao">
                    <div class="icone-wrapper"><i class="bi bi-wrench"></i></div>
                    <div>
                        <h3 class="fw-bold m-0 text-dark">1</h3>
                        <small class="text-muted">Em manutenção</small>
                    </div>
                </div>
            </div>

        </section>

        <!-- SEÇÃO DE FILTROS -->
        <section class="container-filtros mb-4">
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label small fw-bold text-secondary">Período</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-calendar3"></i>
                        </span>
                        <select class="form-select">
                            <option>29/06 - 05/07/2026</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label small fw-bold text-secondary">Turno</label>
                    <select class="form-select">
                        <option>Todos</option>
                    </select>
                </div>

                <div class="col-md-4 text-md-end">
                    <label class="form-label small fw-bold text-secondary d-block text-start text-md-end">
                        Visualização
                    </label>

                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary px-4">Dia</button>
                        <button type="button" class="btn btn-primary px-4">Semana</button>
                        <button type="button" class="btn btn-outline-secondary px-4">Mês</button>
                    </div>
                </div>

            </div>
        </section>

        <!-- TABELA -->
        <section class="table-responsive mb-4">
            <table class="table tabela-cronograma m-0">
                <thead>
                    <tr>
                        <th style="width: 140px;">Sala</th>
                        <th>Seg 29<br><small>29/06</small></th>
                        <th>Ter 30<br><small>30/06</small></th>
                        <th>Qua 01<br><small>01/07</small></th>
                        <th>Qui 02<br><small>02/07</small></th>
                        <th>Sex 03<br><small>03/07</small></th>
                    </tr>
                </thead>

                <tbody>
                    
                    <!-- LINHA: SALA 1 -->
                    <tr>
                        <td class="coluna-sala">
                            <div>Sala 1</div>
                            <div class="capacidade text-muted">Sala de Aula<br>(28)</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-apq"><b>06h - 10h</b><br>APQ Admin</div>
                            <div class="bloco-reserva reserva-tipo-logistica"><b>10h - 12h</b><br>Logística</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-apq"><b>06h - 10h</b><br>APQ Admin</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-apq"><b>06h - 10h</b><br>APQ Admin</div>
                            <div class="bloco-reserva reserva-tipo-logistica"><b>10h - 12h</b><br>Logística</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-apq"><b>06h - 10h</b><br>APQ Admin</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-apq"><b>06h - 10h</b><br>APQ Admin</div>
                            <div class="bloco-reserva reserva-tipo-logistica"><b>10h - 12h</b><br>Logística</div>
                        </td>
                    </tr>

                    <!-- LINHA: SALA 2 -->
                    <tr>
                        <td class="coluna-sala">
                            <div>Sala 2</div>
                            <div class="capacidade text-muted">Sala de Aula<br>(28)</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-redes"><b>08h - 12h</b><br>TI Redes</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-redes"><b>08h - 12h</b><br>TI Redes</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-redes"><b>08h - 12h</b><br>TI Redes</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-redes"><b>08h - 12h</b><br>TI Redes</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-redes"><b>08h - 12h</b><br>TI Redes</div>
                        </td>
                    </tr>

                    <!-- LINHA: LAB 1 -->
                    <tr>
                        <td class="coluna-sala">
                            <div>Lab 1</div>
                            <div class="capacidade text-muted">Laboratório<br>(25)</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-sistemas"><b>13h - 17h</b><br>Dev Sistemas</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-sistemas"><b>13h - 17h</b><br>Dev Sistemas</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-sistemas"><b>13h - 17h</b><br>Dev Sistemas</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-sistemas"><b>13h - 17h</b><br>Dev Sistemas</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-sistemas"><b>13h - 17h</b><br>Dev Sistemas</div>
                        </td>
                    </tr>

                    <!-- LINHA: COZINHA -->
                    <tr>
                        <td class="coluna-sala">
                            <div>Cozinha</div>
                            <div class="capacidade text-muted">Cozinha<br>(20)</div>
                        </td>
                        <td></td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-gastronomia"><b>11h - 14h</b><br>Gastronomia</div>
                        </td>
                        <td></td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-gastronomia"><b>11h - 14h</b><br>Gastronomia</div>
                        </td>
                        <td></td>
                    </tr>

                    <!-- LINHA: AUDITÓRIO -->
                    <tr>
                        <td class="coluna-sala text-danger">
                            <div>Auditório</div>
                            <div class="capacidade text-danger">(50)</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-manutencao"><i
                                    class="bi bi-wrench"></i><br>Manutenção</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-manutencao"><i
                                    class="bi bi-wrench"></i><br>Manutenção</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-manutencao"><i
                                    class="bi bi-wrench"></i><br>Manutenção</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-manutencao"><i
                                    class="bi bi-wrench"></i><br>Manutenção</div>
                        </td>
                        <td>
                            <div class="bloco-reserva reserva-tipo-manutencao"><i
                                    class="bi bi-wrench"></i><br>Manutenção</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- SEÇÃO DE LEGENDAS -->
        <footer class="d-flex flex-wrap justify-content-center gap-4 mb-4 pt-2">
            <div class="item-legenda">
                <span class="circulo-legenda" style="background-color: #f59f00;"></span> Manhã
            </div>
            <div class="item-legenda">
                <span class="circulo-legenda" style="background-color: #d6336c;"></span> Tarde
            </div>
            <div class="item-legenda">
                <span class="circulo-legenda" style="background-color: #3b5bdb;"></span> Noite
            </div>
            <div class="item-legenda">
                <span class="circulo-legenda" style="background-color: #fa5252;"></span> Manutenção
            </div>
            <div class="item-legenda">
                <span class="circulo-legenda" style="background-color: #ced4da;"></span> Feriado
            </div>
        </footer>

        <!-- BARRA INFORMATIVA INFERIOR -->
        <div class="barra-informativa d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill fs-5"></i>
            <span>Clique em um horário para ver detalhes da reserva.</span>
        </div>

    </div> <!-- Fim da div .conteudo-principal -->

    <!-- Bootstrap 5 JS via CDN -->
    <script src="https://jsdelivr.net"></script>
</body>

</html>