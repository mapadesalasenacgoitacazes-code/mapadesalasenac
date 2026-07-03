-- =============================================
-- MAPA DE SALAS SENAC MINAS
-- Script de criacao do banco de dados
-- Versao 2.0 | Junho 2026
-- =============================================

-- 1. UNIDADE
CREATE TABLE unidade (
    id_unidade INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cidade VARCHAR(60) NOT NULL,
    estado CHAR(2) NOT NULL DEFAULT 'MG',
    endereco VARCHAR(200),
    ativo BOOLEAN NOT NULL DEFAULT TRUE
);

-- 2. USUARIO
CREATE TABLE usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    id_unidade INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    perfil ENUM('Admin', 'Supervisao', 'Suporte', 'Docente') NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT TRUE,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_unidade) REFERENCES unidade(id_unidade)
);

-- 3. SALA
CREATE TABLE sala (
    id_sala INT PRIMARY KEY AUTO_INCREMENT,
    id_unidade INT NOT NULL,
    numero VARCHAR(20) NOT NULL,
    tipo ENUM('Sala de Aula', 'Laboratorio', 'Auditorio', 'Cozinha', 'Especial') NOT NULL,
    capacidade INT NOT NULL,
    andar VARCHAR(20),
    status ENUM('Disponivel', 'Ocupada', 'Manutencao') NOT NULL DEFAULT 'Disponivel',
    observacao VARCHAR(255),
    FOREIGN KEY (id_unidade) REFERENCES unidade(id_unidade),
    UNIQUE (id_unidade, numero)
);

-- 4. RECURSO DA SALA
CREATE TABLE recurso_sala (
    id_recurso INT PRIMARY KEY AUTO_INCREMENT,
    id_sala INT NOT NULL,
    descricao VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    FOREIGN KEY (id_sala) REFERENCES sala(id_sala) ON DELETE CASCADE
);

-- 5. CURSO
CREATE TABLE curso (
    id_curso INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    tipo_curso ENUM('Cursos Ageis', 'Graduacao', 'Pos Graduacao', 'Tecnico') NOT NULL,
    area ENUM(
        'Gestao', 'Comercio', 'Comunicacao', 'Artes', 'Design',
        'Saude', 'Tecnologia da Informacao', 'Idioma', 'Educacional',
        'Lazer', 'Moda', 'Beleza', 'Turismo', 'Social',
        'Producao de Alimentos', 'Seguranca', 'Hospedagem',
        'Gastronomia', 'Eventos', 'Asseio e Conservacao',
        'Meio Ambiente e Saude', 'Meio Ambiente e Recursos Naturais',
        'Games'
    ) NOT NULL,
    programa ENUM('Todos', 'Senac Mais', 'PSG') NOT NULL DEFAULT 'Todos',
    carga_horaria_total INT NOT NULL,
    ativo BOOLEAN NOT NULL DEFAULT TRUE
);

-- 6. TURMA
CREATE TABLE turma (
    id_turma INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(20) NOT NULL UNIQUE,
    id_curso INT NOT NULL,
    turno ENUM('Manha', 'Tarde', 'Noite') NOT NULL,
    data_inicio DATE NOT NULL,
    data_termino_prevista DATE NOT NULL,
    data_termino_calculada DATE,
    dias_semana VARCHAR(30) NOT NULL,
    descricao TEXT,
    observacao TEXT,
    ativa BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (id_curso) REFERENCES curso(id_curso)
);

-- 6b. PROFESSORES DA TURMA (N:N — uma turma pode ter varios professores)
CREATE TABLE professor_turma (
    id_professor_turma INT PRIMARY KEY AUTO_INCREMENT,
    id_turma INT NOT NULL,
    id_usuario INT NOT NULL,
    principal BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_turma) REFERENCES turma(id_turma) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario),
    UNIQUE (id_turma, id_usuario)
);

-- 7. RESERVA
CREATE TABLE reserva (
    id_reserva INT PRIMARY KEY AUTO_INCREMENT,
    id_sala INT NOT NULL,
    id_turma INT NOT NULL,
    data DATE NOT NULL,
    turno ENUM('Manha', 'Tarde', 'Noite') NOT NULL,
    status ENUM('Ativa', 'Cancelada') NOT NULL DEFAULT 'Ativa',
    observacao VARCHAR(255),
    criada_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    criada_por INT,
    FOREIGN KEY (id_sala) REFERENCES sala(id_sala),
    FOREIGN KEY (id_turma) REFERENCES turma(id_turma),
    FOREIGN KEY (criada_por) REFERENCES usuario(id_usuario),
    UNIQUE (id_sala, data, turno)
);

-- 8. FERIADO / RECESSO
CREATE TABLE feriado (
    id_feriado INT PRIMARY KEY AUTO_INCREMENT,
    id_unidade INT NOT NULL,
    data DATE NOT NULL,
    descricao VARCHAR(100) NOT NULL,
    tipo ENUM('Nacional', 'Estadual', 'Municipal', 'Recesso') NOT NULL,
    FOREIGN KEY (id_unidade) REFERENCES unidade(id_unidade),
    UNIQUE (id_unidade, data)
);

-- 9. DIA CANCELADO (dia sem aula que estende o termino)
CREATE TABLE dia_cancelado (
    id_cancelamento INT PRIMARY KEY AUTO_INCREMENT,
    id_turma INT NOT NULL,
    data DATE NOT NULL,
    motivo VARCHAR(200) NOT NULL,
    registrado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    registrado_por INT,
    FOREIGN KEY (id_turma) REFERENCES turma(id_turma),
    FOREIGN KEY (registrado_por) REFERENCES usuario(id_usuario),
    UNIQUE (id_turma, data)
);

-- 10. LOG DE ALTERACOES
CREATE TABLE log_alteracao (
    id_log INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    acao VARCHAR(50) NOT NULL,
    tabela_afetada VARCHAR(50) NOT NULL,
    id_registro INT,
    descricao VARCHAR(500),
    data_hora DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

-- =============================================
-- CONSTRAINT CRITICA: impede conflito de reserva
-- Mesma sala + mesmo dia + mesmo turno = UNICO
-- Ja garantido pela UNIQUE (id_sala, data, turno)
-- na tabela reserva
-- =============================================

-- =============================================
-- VIEWS UTEIS
-- =============================================

-- Progresso de cada turma
CREATE VIEW vw_progresso_turma AS
SELECT
    t.id_turma,
    t.codigo,
    c.nome AS curso,
    c.tipo_curso,
    c.area,
    t.turno,
    t.data_inicio,
    t.data_termino_prevista,
    t.data_termino_calculada,
    COUNT(DISTINCT CASE WHEN r.data <= CURDATE() AND r.status = 'Ativa' THEN r.data END) AS dias_realizados,
    COUNT(DISTINCT CASE WHEN r.status = 'Ativa' THEN r.data END) AS dias_previstos,
    ROUND(
        COUNT(DISTINCT CASE WHEN r.data <= CURDATE() AND r.status = 'Ativa' THEN r.data END) * 100.0
        / NULLIF(COUNT(DISTINCT CASE WHEN r.status = 'Ativa' THEN r.data END), 0)
    , 1) AS progresso_percentual
FROM turma t
JOIN curso c ON c.id_curso = t.id_curso
LEFT JOIN reserva r ON r.id_turma = t.id_turma
GROUP BY t.id_turma;

-- Professores por turma (auxiliar)
CREATE VIEW vw_professores_turma AS
SELECT
    pt.id_turma,
    t.codigo,
    GROUP_CONCAT(u.nome ORDER BY pt.principal DESC SEPARATOR ', ') AS professores
FROM professor_turma pt
JOIN usuario u ON u.id_usuario = pt.id_usuario
JOIN turma t ON t.id_turma = pt.id_turma
GROUP BY pt.id_turma;

-- Historico de salas por turma
CREATE VIEW vw_historico_salas_turma AS
SELECT
    t.codigo AS codigo_turma,
    c.nome AS curso,
    s.numero AS sala,
    s.tipo AS tipo_sala,
    MIN(r.data) AS primeira_vez,
    MAX(r.data) AS ultima_vez,
    COUNT(r.data) AS total_dias
FROM reserva r
JOIN turma t ON t.id_turma = r.id_turma
JOIN sala s ON s.id_sala = r.id_sala
JOIN curso c ON c.id_curso = t.id_curso
WHERE r.status = 'Ativa'
GROUP BY t.codigo, c.nome, s.numero, s.tipo
ORDER BY t.codigo, primeira_vez;

-- Ocupacao atual por sala
CREATE VIEW vw_ocupacao_hoje AS
SELECT
    s.numero,
    s.tipo,
    s.capacidade,
    s.status AS status_sala,
    r_m.id_turma AS turma_manha,
    r_t.id_turma AS turma_tarde,
    r_n.id_turma AS turma_noite
FROM sala s
LEFT JOIN reserva r_m ON r_m.id_sala = s.id_sala AND r_m.data = CURDATE() AND r_m.turno = 'Manha' AND r_m.status = 'Ativa'
LEFT JOIN reserva r_t ON r_t.id_sala = s.id_sala AND r_t.data = CURDATE() AND r_t.turno = 'Tarde' AND r_t.status = 'Ativa'
LEFT JOIN reserva r_n ON r_n.id_sala = s.id_sala AND r_n.data = CURDATE() AND r_n.turno = 'Noite' AND r_n.status = 'Ativa';
