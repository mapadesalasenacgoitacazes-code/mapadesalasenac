# Analise de Requisitos de Software

Atividade solicitada em sala de aula no curso Tecnico em Desenvolvimento de Sistemas (Senac Minas), disciplina UC 7. O exercicio consiste em analisar requisitos de 4 sistemas reais utilizando tecnicas de engenharia de requisitos.

Alem da analise, foi gerado um **guia de estudos** complementar sobre os conceitos aplicados.

## Sistemas analisados

| # | Sistema | Dominio | Dados reais utilizados |
|---|---------|---------|----------------------|
| 1 | Google Maps | Mapeamento e navegacao | 2B MAU, SLA 99,9%, incidente real fev/2026 |
| 2 | Airbnb | Marketplace de hospedagens | 8M anuncios, PCI-DSS Level 1, framework Orpheus |
| 3 | Uber | Mobilidade sob demanda | 36M viagens/dia, arquitetura DOMA, grid H3 |
| 4 | Trello | Gestao visual Kanban | 50M+ usuarios, Socket.io, last-write-wins |

## O que cada ficha cobre

- **Mapeamento de atores** com dados reais de escala
- **10 funcionalidades principais** verificadas no sistema real
- **Priorizacao MoSCoW** (regra DSDM: Must Have <= 60% do esforco)
- **Requisitos nao funcionais** baseados na ISO 25010
- **Cenario de excecao** com fallbacks e tratamento de erros reais
- **Observacoes tecnicas** com citacao de fontes

## Priorizacao MoSCoW

### Google Maps

![MoSCoW Google Maps](images/moscow_google_maps.svg)

### Airbnb

![MoSCoW Airbnb](images/moscow_airbnb.svg)

### Uber

![MoSCoW Uber](images/moscow_uber.svg)

### Trello

![MoSCoW Trello](images/moscow_trello.svg)

## Guia de estudos

O arquivo `guia/Guia_de_Estudo_Requisitos.html` contem um guia de estudos sobre os conceitos aplicados nesta atividade, incluindo:

- Requisitos funcionais vs. nao funcionais
- Tecnicas de elicitacao (BABOK)
- Priorizacao MoSCoW e regra DSDM
- Modelo de qualidade ISO 25010
- Padrao IEEE 830
- Links para videos de referencia (PT-BR e EN)

## Estrutura do repositorio

```
├── analise_aprofundada/           # Fichas de analise de requisitos (HTML)
│   ├── Ficha_Requisitos_01_Google_Maps.html
│   ├── Ficha_Requisitos_02_Airbnb.html
│   ├── Ficha_Requisitos_03_Uber.html
│   └── Ficha_Requisitos_04_Trello.html
│
├── guia/                          # Material de estudo
│   ├── Guia_de_Estudo_Requisitos.html
│   └── Guia para Coleta e Analise de Requisitos de Software.pdf
│
├── images/                        # Diagramas MoSCoW
│   ├── moscow_google_maps.svg
│   ├── moscow_airbnb.svg
│   ├── moscow_uber.svg
│   └── moscow_trello.svg
│
└── README.md
```

## Como visualizar

As fichas em HTML podem ser abertas diretamente no navegador.

## Referencias bibliograficas

### Normas e padroes

- IEEE. **IEEE 830-1998: Recommended Practice for Software Requirements Specifications**. Institute of Electrical and Electronics Engineers, 1998.
- ISO/IEC. **ISO/IEC 25010:2011 - Systems and software engineering: Systems and software Quality Requirements and Evaluation (SQuaRE)**. International Organization for Standardization, 2011.
- IIBA. **BABOK Guide v3: A Guide to the Business Analysis Body of Knowledge**. International Institute of Business Analysis, 2015.
- Clegg, D.; Barker, R. **Case Method Fast-Track: A RAD Approach (DSDM/MoSCoW)**. Addison-Wesley, 1994.

### Google Maps

- Alphabet Inc. **Alphabet Q3 2024 Earnings Call Transcript**. SEC Filing, outubro 2024. Disponivel em: abc.xyz/investor.
- Google. **Google Maps Platform Service Level Agreement (SLA)**. Disponivel em: cloud.google.com/maps-platform/terms/sla.
- Google. **Google Maps Platform Documentation: Routes API**. Disponivel em: developers.google.com/maps/documentation/routes.
- Google. **Google Cloud Status Dashboard: Incident 163VbP2njo8deNYScb4v**. Fevereiro 2026. Disponivel em: status.cloud.google.com.
- Google. **Local Guides Connect: Program Overview**. Disponivel em: maps.google.com/localguides.
- Google. **GAAD 2024: Accessibility Updates for Google Maps**. Google Blog, maio 2024.

### Airbnb

- Airbnb Inc. **Airbnb Q4 2024 Earnings Release (SEC 8-K)**. Fevereiro 2025. Disponivel em: investors.airbnb.com.
- Airbnb Inc. **Airbnb SEC 10-K FY2024: Annual Report**. Securities and Exchange Commission, 2025.
- Airbnb Engineering. **"Avoiding Double Payments in a Distributed Payments System"**. Airbnb Tech Blog, Medium. Disponivel em: medium.com/airbnb-engineering.
- Airbnb Engineering. **Orpheus: Idempotency Framework for Payment Consistency**. Airbnb Tech Blog.
- Braintree (PayPal). **PCI-DSS Level 1 Compliance Documentation**. Disponivel em: braintreepayments.com/features/data-security.
- DemandSage. **Airbnb Statistics 2025: Users, Revenue, Listings**. Disponivel em: demandsage.com.
- Hostify. **Airbnb Host Statistics and Trends**. Hostify Blog, 2025.
- Uplisting. **Airbnb Review Policy Guide: Double-Blind System**. Disponivel em: uplisting.io.
- Zeevou. **Airbnb Cancellation Policy Guide: 6 Tiers Explained**. Disponivel em: zeevou.com.
- ByteByteGo. **Airbnb Architecture: System Design Case Study**. Disponivel em: bytebytego.com.
- ITNEXT. **"Solving Double Booking at Scale"**. Disponivel em: itnext.io.

### Uber

- Uber Technologies Inc. **Uber SEC 10-K FY2024: Annual Report**. Securities and Exchange Commission, 2025.
- Uber Engineering. **"Marketplace Matching: Real-Time Optimization"**. Uber Engineering Blog. Disponivel em: eng.uber.com.
- Uber Engineering. **"H3: Uber's Hexagonal Hierarchical Spatial Index"**. Uber Engineering Blog. Disponivel em: eng.uber.com/h3.
- Uber Engineering. **"DOMA: Domain-Oriented Microservice Architecture"**. Uber Engineering Blog, 2020.
- Uber Engineering. **"Kalman Filter and Viterbi Algorithm for GPS Smoothing"**. Uber Engineering Blog.
- Uber. **H3: Hexagonal Hierarchical Geospatial Indexing System**. Open-source documentation. Disponivel em: h3geo.org.
- DemandSage. **Uber Statistics 2025: Trips, Drivers, Revenue**. Disponivel em: demandsage.com.
- Business of Apps. **Uber Revenue and Usage Statistics 2025**. Disponivel em: businessofapps.com/data/uber-statistics.
- CSO Online. **"Uber Breach 2022: Lapsus$ Group, MFA Fatigue Attack"**. CSO Online, setembro 2022.
- InfoQ. **"Uber's Domain-Oriented Microservice Architecture (DOMA)"**. InfoQ, 2021.

### Trello

- Trello. **Trello Help Center: Board Permissions and Roles**. Disponivel em: support.atlassian.com/trello.
- Trello. **Trello Help: Limits and Quotas (5,000 cards)**. Disponivel em: support.atlassian.com/trello.
- Trello. **Trello Developer API Documentation: Actions and WebSocket Events**. Disponivel em: developer.atlassian.com/cloud/trello.
- Trello Engineering. **"Trello Tech Stack: Node.js, MongoDB, Redis, HAProxy"**. Trello Engineering Blog.
- Trello Engineering. **"WebSocket Architecture and Real-Time Sync"**. Trello Engineering Blog.
- Atlassian. **Atlassian Cloud Service Level Agreement (SLA): 99.9% Uptime**. Disponivel em: atlassian.com/legal/sla.
- Atlassian. **Atlassian Trust Center: SOC 2 Type II, ISO 27001 Certifications**. Disponivel em: atlassian.com/trust.
- Atlassian. **Atlassian Pricing: Free, Standard, Premium, Enterprise**. Disponivel em: atlassian.com/software/trello/pricing.
- Atlassian Community. **"Concurrent Editing and Conflict Resolution in Trello"**. Atlassian Community Forum.
- Business of Apps. **Trello Revenue and Usage Statistics 2025**. Disponivel em: businessofapps.com/data/trello-statistics.

## Contexto academico

- **Instituicao**: Senac Minas
- **Curso**: Tecnico em Desenvolvimento de Sistemas
- **Disciplina**: UC 7, Aplicacoes em Desenvolvimento Web
- **Aluna**: Thais Oliveira
