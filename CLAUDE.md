# Mapa de Salas SENAC Minas

## Sobre o projeto

Sistema web para gerenciamento de reservas de salas do SENAC Minas BH, substituindo a planilha Excel atual. Projeto final do curso Tecnico em Desenvolvimento de Sistemas (UC 7).

## Stack

- **Backend:** PHP 8 (MVC puro, sem framework)
- **Banco:** MySQL 8
- **Frontend:** HTML + CSS + JS + Bootstrap 5
- **Servidor:** Apache (XAMPP ou Laragon)
- **Autenticacao:** PHP Sessions + password_hash()
- **Seguranca:** PDO com prepared statements

## Estrutura do projeto

```
docs/
  01-levantamento/    # Documento de requisitos, fichas
  02-analise/         # PRD, DER
  03-planejamento/    # Cronograma, sprints
  04-design/          # Prototipos de telas
  05-referencias/     # Material do professor
database/
  schema.sql          # DDL completo (11 tabelas + 4 views)
src/
  public/             # Document root do Apache
    css/ js/ img/
    index.php
  app/
    controllers/
    models/
    views/
    config/
tests/
```

## Etapas do projeto

1. Levantamento de Requisitos - Concluido 29/06/2026
2. Analise de Requisitos - A fazer
3. Planejamento - A fazer
4. Projeto (Design) - A fazer
5. Desenvolvimento (Implementacao) - A fazer
6. Testes - A fazer
7. Implantacao (Deploy) - A fazer

## Regras de negocio criticas

- Constraint UNIQUE (id_sala, data, turno) na tabela reserva impede conflitos
- Dia sem aula estende +1 dia no termino do curso
- Reserva por turno (Manha/Tarde/Noite), nao por dia inteiro
- Uma turma pode ter varios professores (tabela professor_turma)
- Cada unidade define seus proprios feriados/recessos

## Cores SENAC

- Azul: #004C94
- Laranja: #F7941D
- Laranja Claro: #FDC180
