-- =============================================
-- MAPA DE SALAS SENAC MINAS
-- Dados de teste (seed) para desenvolvimento
-- Versao 1.0 | Julho 2026
--
-- INSTRUCOES:
-- 1. Execute o schema.sql PRIMEIRO
-- 2. Depois execute este arquivo
-- 3. Senha de todos os usuarios: senac2026
-- =============================================

USE mapa_de_salas;

-- =============================================
-- 1. UNIDADE
-- =============================================
INSERT INTO unidade (nome, cidade, estado, endereco) VALUES
('SENAC BH Centro', 'Belo Horizonte', 'MG', 'Rua dos Timbiras, 1228');

-- =============================================
-- 2. USUARIOS (senha: senac2026 para todos)
-- Hash gerado com password_hash('senac2026', PASSWORD_DEFAULT)
-- =============================================
INSERT INTO usuario (id_unidade, nome, email, senha_hash, perfil) VALUES
(1, 'Ana Paula Silva',  'ana.silva@senacminas.com.br',      '$2y$10$Cs3jpCEpFvftubLmdi/PGuyHmkjRP43nYjjt9SOCDc7KxbvY0yfCu', 'Supervisao'),
(1, 'Carlos Mendes',    'carlos.mendes@senacminas.com.br',   '$2y$10$Cs3jpCEpFvftubLmdi/PGuyHmkjRP43nYjjt9SOCDc7KxbvY0yfCu', 'Suporte'),
(1, 'Maria Santos',     'maria.santos@senacminas.com.br',    '$2y$10$Cs3jpCEpFvftubLmdi/PGuyHmkjRP43nYjjt9SOCDc7KxbvY0yfCu', 'Docente'),
(1, 'Roberto Lima',     'roberto.lima@senacminas.com.br',    '$2y$10$Cs3jpCEpFvftubLmdi/PGuyHmkjRP43nYjjt9SOCDc7KxbvY0yfCu', 'Docente'),
(1, 'Fernanda Costa',   'fernanda.costa@senacminas.com.br',  '$2y$10$Cs3jpCEpFvftubLmdi/PGuyHmkjRP43nYjjt9SOCDc7KxbvY0yfCu', 'Docente');

-- =============================================
-- 3. SALAS (10 salas em 4 andares)
-- =============================================
INSERT INTO sala (id_unidade, numero, tipo, capacidade, andar, status) VALUES
(1, '101',    'Sala de Aula', 40,  '1o Andar', 'Ativa'),
(1, '102',    'Sala de Aula', 40,  '1o Andar', 'Ativa'),
(1, '103',    'Sala de Aula', 35,  '1o Andar', 'Ativa'),
(1, '201',    'Laboratorio',  30,  '2o Andar', 'Ativa'),
(1, '202',    'Laboratorio',  25,  '2o Andar', 'Ativa'),
(1, '203',    'Laboratorio',  30,  '2o Andar', 'Ativa'),
(1, '301',    'Oficina',      20,  '3o Andar', 'Ativa'),
(1, '302',    'Oficina',      20,  '3o Andar', 'Ativa'),
(1, 'AUD-01', 'Auditorio',    120, 'Terreo',   'Ativa'),
(1, '104',    'Sala de Aula', 40,  '1o Andar', 'Manutencao');

-- =============================================
-- 4. CURSOS
-- =============================================
INSERT INTO curso (nome, tipo_curso, area, programa, carga_horaria_total) VALUES
('Tecnico em Desenvolvimento de Sistemas', 'Tecnico',      'Tecnologia da Informacao', 'Todos',      1200),
('APQ em Logistica',                       'Qualificacao', 'Gestao',                   'Senac Mais', 160);

-- =============================================
-- 5. TURMAS
-- =============================================
INSERT INTO turma (codigo, id_curso, turno, data_inicio, data_termino_prevista, dias_semana) VALUES
('006.2026.0042', 1, 'Manha', '2026-02-10', '2026-12-15', 'Seg,Ter,Qua,Qui,Sex'),
('006.2026.0055', 2, 'Tarde', '2026-03-01', '2026-06-30', 'Ter,Qui');

-- =============================================
-- 6. PROFESSORES DAS TURMAS
-- =============================================
INSERT INTO professor_turma (id_turma, id_usuario, principal) VALUES
(1, 3, TRUE),   -- Maria Santos e professora principal da turma de TDS
(1, 4, FALSE),  -- Roberto Lima tambem leciona na turma de TDS
(2, 5, TRUE);   -- Fernanda Costa e professora principal da turma de Logistica

-- =============================================
-- 7. RESERVAS DE EXEMPLO (19 reservas em 2 semanas)
-- Turma 1 (TDS Manha) e Turma 2 (Logistica Tarde)
-- =============================================
INSERT INTO reserva (id_sala, id_turma, data, turno, criada_por) VALUES
-- Semana 29/06 a 03/07
(4, 1, '2026-06-29', 'Manha', 1),  -- TDS na sala 201 (Lab)
(4, 1, '2026-06-30', 'Manha', 1),
(4, 1, '2026-07-01', 'Manha', 1),
(4, 1, '2026-07-02', 'Manha', 1),
(1, 1, '2026-07-03', 'Manha', 1),  -- TDS na sala 101 (sexta em sala de aula)
(2, 2, '2026-06-29', 'Tarde', 2),  -- Logistica na sala 102
(2, 2, '2026-07-01', 'Tarde', 2),
(2, 2, '2026-07-03', 'Tarde', 2),
(5, 2, '2026-06-30', 'Tarde', 2),  -- Logistica na sala 202 (Lab)
(5, 2, '2026-07-02', 'Tarde', 2),
-- Reservas extras para variar o mapa
(1, 1, '2026-06-29', 'Noite', 1),
(3, 2, '2026-07-01', 'Noite', 2),
(9, 1, '2026-07-01', 'Tarde', 1),  -- TDS no Auditorio
(7, 2, '2026-06-29', 'Manha', 2),  -- Logistica na Oficina 301
(7, 2, '2026-07-01', 'Manha', 2),
(3, 1, '2026-06-30', 'Tarde', 1),
(3, 1, '2026-07-02', 'Tarde', 1),
(6, 1, '2026-07-03', 'Manha', 1),  -- TDS no Lab 203
(6, 2, '2026-07-03', 'Tarde', 2);  -- Logistica no Lab 203
