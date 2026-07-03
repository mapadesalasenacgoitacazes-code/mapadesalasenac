# Prototipos de Telas - Mapa de Salas SENAC Minas

> Wireframes de media fidelidade | Paleta oficial SENAC | 13 telas  
> **Versao 1.0** - Primeira versao para referencia do time de front-end

---
## Tela 01 - Login

Tela inicial do sistema. O usuario informa **e-mail institucional** e **senha** para acessar. O perfil (Admin, Supervisao, Suporte, Docente) define as permissoes apos o login. A sessao expira apos **30 minutos de inatividade**.

- **Requisito:** RF01
- **Prioridade:** Must (Obrigatorio)

<img width="1260" height="559" alt="tela_01" src="https://github.com/user-attachments/assets/7c88518d-5350-41b7-bff5-19f6204639aa" />

## Tela 02 - Painel Principal (Calendario de Salas)

Tela principal apos login, **substitui a planilha Excel**. Visao semanal com salas nas linhas e dias nas colunas. Possui **4 modos de visualizacao** (Dia, Semana, Mes, Ano) e filtros por turno, tipo de sala e andar. Cards superiores mostram totais de salas cadastradas, disponiveis, ocupadas e em manutencao.

- **Requisitos:** RF11, RF12
- **Prioridade:** Must (Obrigatorio)
<img width="1260" height="672" alt="tela_02" src="https://github.com/user-attachments/assets/a659f232-3769-40ce-b362-f4f7950218d4" />
---
## Tela 03 - Cadastro de Salas

Listagem de salas com tabela contendo numero, tipo, capacidade, andar e status. Formulario lateral para cadastrar nova sala com campos obrigatorios. Permite editar e alterar status (**Disponivel**, **Ocupada**, **Manutencao**).

- **Requisito:** RF02
- **Prioridade:** Must (Obrigatorio)

<img width="1260" height="794" alt="tela_03" src="https://github.com/user-attachments/assets/10486b26-4426-4a0a-b9d1-97ae4e919ef0" />
---
## Tela 04 - Cadastro de Turmas

Cadastro com codigo, curso, professor(es), turno e dias da semana fixos. Tabela com filtros por tipo de curso, area, programa e progresso. Suporta **multiplos professores por turma** com indicacao de professor principal.

- **Requisitos:** RF04, RF12, RF15
- **Prioridade:** Must (Obrigatorio)
<img width="1260" height="1154" alt="tela_04" src="https://github.com/user-attachments/assets/fd29185f-d2b8-4785-8265-8a13aec716f2" />

---
## Tela 05 - Criar Reserva (Modal)

Modal que abre ao clicar em "Nova Reserva" ou em um dia vazio no calendario. Campos: sala, turma, data, turno e observacao. Exibe **alerta de conflito** quando a sala ja esta reservada naquele turno. Mostra salas disponiveis no mesmo horario como alternativa.

- **Requisitos:** RF06, RN01, RN02
- **Prioridade:** Must (Obrigatorio)
- **Regra critica:** `UNIQUE(id_sala, data, turno)` impede conflitos
<img width="1260" height="676" alt="tela_05" src="https://github.com/user-attachments/assets/2af7daac-3374-44ed-b283-9373757d6d56" />

---

## Tela 06 - Historico de Salas por Turma

Visualizacao do historico de alocacao de uma turma. Mostra timeline com todas as salas utilizadas, datas de uso e total de dias em cada sala. Permite consultar por codigo da turma ou nome do curso.

- **Requisito:** RF13
- **Prioridade:** Should (Importante)
<img width="1260" height="726" alt="tela_06" src="https://github.com/user-attachments/assets/e672572e-637c-47aa-b692-e22e366150a9" />

---

## Tela 07 - Cadastro de Cursos

Listagem e cadastro de cursos com nome, tipo (Ageis, Graduacao, Pos Graduacao, Tecnico), **area SENAC** (23 areas), programa (Todos, Senac Mais, PSG) e carga horaria total. Filtros por tipo, area e status.

- **Requisito:** RF03
- **Prioridade:** Should (Importante)
<img width="1260" height="694" alt="tela_07" src="https://github.com/user-attachments/assets/4d7e4ddd-2b36-4fe1-8485-3f131c968dc5" />

---

## Tela 08 - Cadastro de Feriados e Recessos

Gerenciamento de feriados e recessos por unidade. Campos: data, descricao e tipo (**Nacional**, **Estadual**, **Municipal**, **Recesso**). Calendario visual destaca os dias cadastrados. Cada unidade define seus proprios feriados.

- **Requisito:** RF09
- **Prioridade:** Should (Importante)
<img width="1260" height="780" alt="tela_08" src="https://github.com/user-attachments/assets/06cd5ff5-01e9-46a8-b445-0f11088854fc" />

---

## Tela 09 - Registrar Dia sem Aula

Registro de dias cancelados para uma turma especifica. Campos: turma, data e motivo.

- **Requisito:** RF10
- **Prioridade:** Should (Importante)
- **Regra critica:** Cada dia sem aula estende em **+1 dia** a data de termino calculada da turma
<img width="1260" height="780" alt="tela_09" src="https://github.com/user-attachments/assets/16ef07ec-38af-4c8f-9b8a-94924bd7e05f" />

---

## Tela 10 - Log de Auditoria

Listagem de todas as acoes realizadas no sistema. Mostra usuario, acao (criacao, edicao, cancelamento), tabela afetada, ID do registro, descricao e data/hora. Filtros por tabela, acao, periodo e busca por texto.

- **Requisito:** RF16
- **Prioridade:** Could (Desejavel)
<img width="1260" height="667" alt="tela_10" src="https://github.com/user-attachments/assets/df0696d6-e0b9-492e-ba40-d7f1f2907213" />

---

## Tela 11 - Dashboard de Ocupacao

Painel visual com graficos de ocupacao das salas. Mostra taxa de ocupacao por turno, salas mais utilizadas, ranking por tipo de sala e evolucao mensal. Filtros por periodo e unidade.

- **Requisito:** RF14
- **Prioridade:** Could (Desejavel)
<img width="1260" height="668" alt="tela_11" src="https://github.com/user-attachments/assets/406cf6f6-8b48-4e57-a165-f3c7e761b37a" />

---

## Tela 12 - Gestao de Usuarios (Admin)

Painel administrativo para criar, editar e desativar contas de usuario. Tabela com nome, e-mail, perfil, unidade, status e data de criacao. Formulario para novo usuario com definicao de perfil de acesso e unidade.

- **Requisito:** RF01
- **Prioridade:** Could (Desejavel)
- **Perfis:** Supervisao (acesso total), Suporte (cadastros + reservas), Docente (somente leitura + proprias turmas)
<img width="1260" height="893" alt="tela_12" src="https://github.com/user-attachments/assets/358b2069-fd1b-40fb-9600-143141c249ef" />

---

## Tela 13 - Historico de Modificacoes

Visualizacao detalhada do historico de alteracoes de um registro especifico. Mostra quem alterou, quando e o que mudou com comparacao **valor anterior** versus **valor novo** em cores (vermelho para antigo, verde para novo). Filtros por tabela, acao, periodo e busca.

- **Requisito:** RF16
- **Prioridade:** Could (Desejavel)
<img width="1260" height="910" alt="tela_13" src="https://github.com/user-attachments/assets/69032ac2-36c5-489c-a45d-ab9d686f2c06" />

---

## Paleta de cores SENAC

| Cor | Hex | Uso |
|-----|-----|-----|
| Azul SENAC | `#004C94` | Navbar, titulos, botoes primarios |
| Azul Escuro | `#003366` | Hover, cabecalhos de tabela |
| Laranja | `#F7941D` | Botoes de acao, destaques |
| Laranja Claro | `#FDC180` | Reservas, backgrounds suaves |
| Verde | - | Status ativo, disponivel |
| Vermelho | - | Alertas, conflitos, cancelamentos |

---

## Observacoes para o time de front-end

- Estes sao **wireframes de media fidelidade**, nao o design final
- Os dados exibidos nas telas sao **ficticios** e servem apenas como exemplo
- O time de front-end fara as melhorias visuais e de interacao
- A estrutura de navegacao (navbar + sidebar) deve ser consistente entre as telas
- Responsividade mobile nao esta contemplada nesta versao


