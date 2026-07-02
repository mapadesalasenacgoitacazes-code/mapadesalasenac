# Mapa de Salas — SENAC Minas

Sistema web para gerenciamento de reservas, monitoramento e organizacao de salas de cursos do SENAC Minas BH. Substitui a planilha Excel utilizada atualmente.

## Contexto

- **Instituicao:** SENAC Minas — Unidade BH
- **Curso:** Tecnico em Desenvolvimento de Sistemas
- **Disciplina:** UC 7
- **Equipe:** 
- **Professor:** Cleiton Pereira

## Stack tecnologica

| Camada | Tecnologia |
|--------|-----------|
| Backend | PHP 8 (MVC puro, sem framework) |
| Banco de dados | MySQL 8 |
| Frontend | HTML + CSS + JS + Bootstrap 5 |
| Servidor | Apache (XAMPP / Laragon) |
| Autenticacao | PHP Sessions + password_hash() |
| Seguranca | PDO com prepared statements |

## Etapas do projeto

| # | Etapa | Status | Data |
|---|-------|--------|------|
| 1 | Levantamento de Requisitos | Concluido | 29/06/2026 |
| 2 | Analise de Requisitos | A fazer | — |
| 3 | Planejamento | A fazer | — |
| 4 | Projeto (Design) | A fazer | — |
| 5 | Desenvolvimento (Implementacao) | A fazer | — |
| 6 | Testes | A fazer | — |
| 7 | Implantacao (Deploy) | A fazer | — |

## Estrutura do repositorio

```
projeto-mapa-de-sala-senac/
│
├── docs/                              # Documentacao do projeto
│   ├── 01-levantamento/               # Requisitos (RF, RNF, RN)
│   │   ├── Documento_de_Requisitos.html
│   │   └── Ficha_Requisitos_Mapa_de_Salas.html
│   ├── 02-analise/                    # PRD e modelagem
│   │   ├── PRD_Mapa_de_Salas.html
│   │   └── DER_Mapa_de_Salas.html
│   ├── 03-planejamento/               # Cronograma e sprints
│   ├── 04-design/                     # Prototipos e wireframes
│   │   └── Prototipos_Telas.html
│   └── 05-referencias/               # Material do professor
│
├── database/                          # Scripts SQL
│   └── schema.sql                     # 11 tabelas + 4 views
│
├── src/                               # Codigo-fonte (PHP MVC)
│   ├── public/                        # Document root do Apache
│   │   ├── index.php
│   │   ├── css/
│   │   ├── js/
│   │   └── img/
│   └── app/
│       ├── controllers/
│       ├── models/
│       ├── views/
│       └── config/
│
├── tests/                             # Testes
├── CLAUDE.md                          # Contexto para IA
└── README.md
```

## Funcionalidades principais

- Autenticacao com perfis (Admin, Supervisao, Suporte, Docente)
- Cadastro de salas com tipo, andar, capacidade e recursos
- Cadastro de cursos com tipo (Ageis/Graduacao/Pos/Tecnico) e 23 areas SENAC
- Cadastro de turmas com multiplos professores
- Reserva de salas por turno com validacao de conflito
- Calendario com visao Dia / Semana / Mes / Ano
- Historico de salas por turma
- Calculo automatico de progresso
- Dashboard de ocupacao
- Log de auditoria

## Banco de dados

O schema (`database/schema.sql`) contem:
- **11 tabelas:** unidade, usuario, sala, recurso_sala, curso, turma, professor_turma, reserva, feriado, dia_cancelado, log_alteracao
- **4 views:** vw_progresso_turma, vw_historico_salas_turma, vw_ocupacao_hoje, vw_professores_turma
- **Constraint critica:** `UNIQUE(id_sala, data, turno)` impede conflito de reserva

## Como visualizar a documentacao

Os arquivos `.html` na pasta `docs/` podem ser abertos diretamente no navegador.

## Uso de IA

Este projeto contou com o auxilio do Claude (Anthropic) como ferramenta de pesquisa, organizacao e geracao de documentacao. As decisoes de arquitetura, priorizacao de requisitos e regras de negocio partiram da analise da equipe com base nas entrevistas realizadas com a cliente.
