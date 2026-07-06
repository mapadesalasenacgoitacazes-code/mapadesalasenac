<?php

require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/config/Auth.php';

require_once __DIR__ . '/../app/models/UnidadeModel.php';
require_once __DIR__ . '/../app/models/UsuarioModel.php';
require_once __DIR__ . '/../app/models/SalaModel.php';
require_once __DIR__ . '/../app/models/CursoModel.php';
require_once __DIR__ . '/../app/models/TurmaModel.php';
require_once __DIR__ . '/../app/models/ReservaModel.php';
require_once __DIR__ . '/../app/models/FeriadoModel.php';
require_once __DIR__ . '/../app/models/DiaCanceladoModel.php';
require_once __DIR__ . '/../app/models/LogModel.php';

Auth::init();

$page = $_GET['page'] ?? 'login';
$acao = $_GET['acao'] ?? 'listar';

if ($page !== 'login' && $page !== 'logout') {
    Auth::verificarLogin();
}

switch ($page) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $senha = $_POST['senha'] ?? '';
            if ($email && Auth::login($email, $senha)) {
                header('Location: index.php?page=painel');
                exit;
            }
            $erro = 'E-mail ou senha invalidos';
        }
        require __DIR__ . '/../app/views/login.php';
        break;

    case 'logout':
        Auth::logout();
        break;

    case 'painel':
        $reservaModel = new ReservaModel();
        $salaModel    = new SalaModel();
        $idUnidade    = $_SESSION['id_unidade'];

        $inicioSemana = $_GET['inicio'] ?? date('Y-m-d', strtotime('monday this week'));
        $fimSemana    = date('Y-m-d', strtotime($inicioSemana . ' +6 days'));

        $filtros = [
            'turno'     => $_GET['turno'] ?? null,
            'tipo_sala' => $_GET['tipo_sala'] ?? null,
            'andar'     => $_GET['andar'] ?? null,
        ];

        $reservas    = $reservaModel->listarPorSemana($idUnidade, $inicioSemana, $fimSemana, $filtros);
        $salas       = $salaModel->listarPorUnidade($idUnidade);
        $andares     = $salaModel->listarAndares($idUnidade);
        $totalSalas  = count($salas);
        $ocupacaoHoje = $reservaModel->ocupacaoHoje($idUnidade);

        require __DIR__ . '/../app/views/painel.php';
        break;

    case 'salas':
        Auth::verificarPerfil(['Admin', 'Supervisao', 'Suporte']);
        $salaModel = new SalaModel();
        $idUnidade = $_SESSION['id_unidade'];

        if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'id_unidade'  => $idUnidade,
                'numero'      => htmlspecialchars($_POST['numero']),
                'tipo'        => $_POST['tipo'],
                'capacidade'  => (int)$_POST['capacidade'],
                'andar'       => htmlspecialchars($_POST['andar'] ?? ''),
                'observacao'  => htmlspecialchars($_POST['observacao'] ?? ''),
            ];
            $id = $salaModel->criar($dados);
            (new LogModel())->registrar($_SESSION['usuario_id'], 'Criacao', 'sala', $id, "Sala {$dados['numero']} cadastrada");
            header('Location: index.php?page=salas&msg=criada');
            exit;
        }

        if ($acao === 'status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $salaModel->alterarStatus($_POST['id_sala'], $_POST['status']);
            (new LogModel())->registrar($_SESSION['usuario_id'], 'Edicao', 'sala', $_POST['id_sala'], "Status alterado para {$_POST['status']}");
            header('Location: index.php?page=salas&msg=atualizada');
            exit;
        }

        $filtros = [
            'tipo'   => $_GET['tipo'] ?? null,
            'andar'  => $_GET['andar'] ?? null,
            'status' => $_GET['status'] ?? null,
        ];
        $salas   = $salaModel->listarPorUnidade($idUnidade, $filtros);
        $andares = $salaModel->listarAndares($idUnidade);

        require __DIR__ . '/../app/views/salas.php';
        break;

    case 'turmas':
        Auth::verificarPerfil(['Admin', 'Supervisao', 'Suporte']);
        $turmaModel   = new TurmaModel();
        $cursoModel   = new CursoModel();
        $usuarioModel = new UsuarioModel();

        if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'codigo'                => htmlspecialchars($_POST['codigo']),
                'id_curso'              => (int)$_POST['id_curso'],
                'turno'                 => $_POST['turno'],
                'data_inicio'           => $_POST['data_inicio'],
                'data_termino_prevista' => $_POST['data_termino_prevista'],
                'dias_semana'           => implode(',', $_POST['dias_semana'] ?? []),
                'descricao'             => htmlspecialchars($_POST['descricao'] ?? ''),
                'observacao'            => htmlspecialchars($_POST['observacao'] ?? ''),
            ];
            $id = $turmaModel->criar($dados);

            if (!empty($_POST['professores'])) {
                foreach ($_POST['professores'] as $i => $profId) {
                    $principal = ((int)($_POST['professor_principal'] ?? 0) === (int)$profId);
                    $turmaModel->vincularProfessor($id, (int)$profId, $principal);
                }
            }

            (new LogModel())->registrar($_SESSION['usuario_id'], 'Criacao', 'turma', $id, "Turma {$dados['codigo']} cadastrada");
            header('Location: index.php?page=turmas&msg=criada');
            exit;
        }

        $filtros = [
            'turno'      => $_GET['turno'] ?? null,
            'tipo_curso' => $_GET['tipo_curso'] ?? null,
            'area'       => $_GET['area'] ?? null,
            'ativa'      => isset($_GET['ativa']) ? (int)$_GET['ativa'] : null,
            'busca'      => $_GET['busca'] ?? null,
        ];
        $turmas      = $turmaModel->listarTodas($filtros);
        $cursos      = $cursoModel->listarAtivos();
        $professores = $usuarioModel->listarProfessoresAtivos();

        require __DIR__ . '/../app/views/turmas.php';
        break;

    case 'reservas':
        $reservaModel = new ReservaModel();
        $salaModel    = new SalaModel();
        $turmaModel   = new TurmaModel();
        $idUnidade    = $_SESSION['id_unidade'];

        if ($acao === 'criar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::verificarPerfil(['Admin', 'Supervisao', 'Suporte']);
            $dados = [
                'id_sala'    => (int)$_POST['id_sala'],
                'id_turma'   => (int)$_POST['id_turma'],
                'data'       => $_POST['data'],
                'turno'      => $_POST['turno'],
                'observacao' => htmlspecialchars($_POST['observacao'] ?? ''),
            ];
            $resultado = $reservaModel->criar($dados, $_SESSION['usuario_id']);

            if (isset($resultado['erro'])) {
                $erro = $resultado['erro'];
                $salasDisponiveis = $reservaModel->salasDisponiveisNoHorario($idUnidade, $dados['data'], $dados['turno']);
                $salas  = $salaModel->listarDisponiveisParaReserva($idUnidade);
                $turmas = $turmaModel->listarAtivas();
                require __DIR__ . '/../app/views/reserva_criar.php';
                break;
            }

            (new LogModel())->registrar($_SESSION['usuario_id'], 'Criacao', 'reserva', $resultado['id'], "Reserva criada para {$_POST['data']} turno {$_POST['turno']}");
            header('Location: index.php?page=painel&msg=reserva_criada');
            exit;
        }

        if ($acao === 'cancelar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            Auth::verificarPerfil(['Admin', 'Supervisao', 'Suporte']);
            $reservaModel->cancelar((int)$_POST['id_reserva']);
            (new LogModel())->registrar($_SESSION['usuario_id'], 'Cancelamento', 'reserva', $_POST['id_reserva'], "Reserva cancelada");
            header('Location: index.php?page=painel&msg=reserva_cancelada');
            exit;
        }

        if ($acao === 'disponibilidade') {
            $data  = $_GET['data'] ?? date('Y-m-d');
            $turno = $_GET['turno'] ?? 'Manha';
            $salasDisponiveis = $reservaModel->salasDisponiveisNoHorario($idUnidade, $data, $turno);
            require __DIR__ . '/../app/views/reserva_disponibilidade.php';
            break;
        }

        $salas  = $salaModel->listarDisponiveisParaReserva($idUnidade);
        $turmas = $turmaModel->listarAtivas();
        require __DIR__ . '/../app/views/reserva_criar.php';
        break;

    case 'cursos':
        Auth::verificarPerfil(['Admin', 'Supervisao', 'Suporte']);
        $cursoModel = new CursoModel();

        if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome'                => htmlspecialchars($_POST['nome']),
                'tipo_curso'          => $_POST['tipo_curso'],
                'area'                => $_POST['area'],
                'programa'            => $_POST['programa'] ?? 'Todos',
                'carga_horaria_total' => (int)$_POST['carga_horaria_total'],
            ];
            $id = $cursoModel->criar($dados);
            (new LogModel())->registrar($_SESSION['usuario_id'], 'Criacao', 'curso', $id, "Curso {$dados['nome']} cadastrado");
            header('Location: index.php?page=cursos&msg=criado');
            exit;
        }

        $filtros = [
            'tipo_curso' => $_GET['tipo_curso'] ?? null,
            'area'       => $_GET['area'] ?? null,
            'programa'   => $_GET['programa'] ?? null,
            'ativo'      => isset($_GET['ativo']) ? (int)$_GET['ativo'] : null,
        ];
        $cursos = $cursoModel->listarTodos($filtros);
        require __DIR__ . '/../app/views/cursos.php';
        break;

    case 'feriados':
        Auth::verificarPerfil(['Admin', 'Supervisao']);
        $feriadoModel = new FeriadoModel();
        $idUnidade    = $_SESSION['id_unidade'];

        if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'id_unidade' => $idUnidade,
                'data'       => $_POST['data'],
                'descricao'  => htmlspecialchars($_POST['descricao']),
                'tipo'       => $_POST['tipo'],
            ];
            $id = $feriadoModel->criar($dados);
            (new LogModel())->registrar($_SESSION['usuario_id'], 'Criacao', 'feriado', $id, "Feriado cadastrado: {$dados['descricao']} em {$dados['data']}");
            header('Location: index.php?page=feriados&msg=criado');
            exit;
        }

        if ($acao === 'excluir' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $feriadoModel->excluir((int)$_POST['id_feriado']);
            (new LogModel())->registrar($_SESSION['usuario_id'], 'Exclusao', 'feriado', $_POST['id_feriado'], "Feriado excluido");
            header('Location: index.php?page=feriados&msg=excluido');
            exit;
        }

        $ano      = $_GET['ano'] ?? date('Y');
        $feriados = $feriadoModel->listarPorUnidade($idUnidade, $ano);
        require __DIR__ . '/../app/views/feriados.php';
        break;

    case 'dia-cancelado':
        Auth::verificarPerfil(['Admin', 'Supervisao', 'Suporte']);
        $diaModel   = new DiaCanceladoModel();
        $turmaModel = new TurmaModel();

        if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'id_turma' => (int)$_POST['id_turma'],
                'data'     => $_POST['data'],
                'motivo'   => htmlspecialchars($_POST['motivo']),
            ];
            $id = $diaModel->criar($dados, $_SESSION['usuario_id']);
            (new LogModel())->registrar($_SESSION['usuario_id'], 'Criacao', 'dia_cancelado', $id, "Dia sem aula registrado: {$_POST['data']}");
            header('Location: index.php?page=dia-cancelado&msg=criado');
            exit;
        }

        $turmas = $turmaModel->listarAtivas();
        $diasCancelados = [];
        if (!empty($_GET['id_turma'])) {
            $diasCancelados = $diaModel->listarPorTurma((int)$_GET['id_turma']);
        }
        require __DIR__ . '/../app/views/dia_cancelado.php';
        break;

    case 'usuarios':
        Auth::verificarPerfil(['Admin', 'Supervisao']);
        $usuarioModel = new UsuarioModel();
        $unidadeModel = new UnidadeModel();

        if ($acao === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'id_unidade' => (int)$_POST['id_unidade'],
                'nome'       => htmlspecialchars($_POST['nome']),
                'email'      => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL),
                'senha'      => $_POST['senha'],
                'perfil'     => $_POST['perfil'],
            ];

            if (!$dados['email']) {
                $erro = 'E-mail invalido';
            } elseif ($usuarioModel->buscarPorEmail($dados['email'])) {
                $erro = 'E-mail ja cadastrado';
            } elseif (strlen($dados['senha']) < 8) {
                $erro = 'Senha deve ter no minimo 8 caracteres';
            } else {
                $id = $usuarioModel->criar($dados);
                (new LogModel())->registrar($_SESSION['usuario_id'], 'Criacao', 'usuario', $id, "Usuario {$dados['nome']} cadastrado como {$dados['perfil']}");
                header('Location: index.php?page=usuarios&msg=criado');
                exit;
            }
        }

        if ($acao === 'status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel->alterarStatus((int)$_POST['id_usuario'], (int)$_POST['ativo']);
            $status = $_POST['ativo'] ? 'reativado' : 'desativado';
            (new LogModel())->registrar($_SESSION['usuario_id'], 'Edicao', 'usuario', $_POST['id_usuario'], "Usuario $status");
            header('Location: index.php?page=usuarios&msg=atualizado');
            exit;
        }

        $filtros = [
            'perfil' => $_GET['perfil'] ?? null,
            'ativo'  => isset($_GET['ativo']) ? (int)$_GET['ativo'] : null,
            'busca'  => $_GET['busca'] ?? null,
        ];
        $usuarios = $usuarioModel->listarTodos($filtros);
        $unidades = $unidadeModel->listarAtivas();
        require __DIR__ . '/../app/views/usuarios.php';
        break;

    case 'log':
        Auth::verificarPerfil(['Admin', 'Supervisao']);
        $logModel = new LogModel();

        $filtros = [
            'tabela'      => $_GET['tabela'] ?? null,
            'acao'        => $_GET['acao'] ?? null,
            'data_inicio' => $_GET['data_inicio'] ?? null,
            'data_fim'    => $_GET['data_fim'] ?? null,
            'busca'       => $_GET['busca'] ?? null,
        ];

        $pagina     = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina  = 25;
        $offset     = ($pagina - 1) * $porPagina;
        $total      = $logModel->contarTotal($filtros);
        $totalPaginas = ceil($total / $porPagina);
        $logs       = $logModel->listar($filtros, $porPagina, $offset);

        require __DIR__ . '/../app/views/log.php';
        break;

    default:
        header('Location: index.php?page=painel');
        break;
}
