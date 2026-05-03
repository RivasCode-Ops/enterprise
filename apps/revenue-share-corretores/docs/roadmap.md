# roadmap.md

## Revenue Share Corretores

Este documento registra a sequência planejada de evolução do produto.

## Objetivo

Organizar a entrega do MVP em etapas claras, reduzindo retrabalho e mantendo o foco no que valida o negócio primeiro.

## Fase 1 — Base do sistema

- iniciar projeto Laravel;
- configurar ambiente;
- autenticação básica;
- estrutura inicial de usuários.

## Fase 2 — Corretores e imóveis

- cadastro de corretor;
- cadastro de imóveis;
- upload de imagens;
- listagem de imóveis;
- detalhes do imóvel.

## Fase 3 — Busca e leads

- busca por texto;
- filtros principais;
- formulário de contato;
- registro de leads;
- painel básico do corretor.

## Fase 4 — Vendas e revenue share

- registro manual de venda;
- cálculo do split;
- histórico básico;
- visão administrativa inicial.

## Fase 5 — Admin e KPIs

- dashboard admin (revenue, pagamentos, gráficos);
- gestão de corretores e pagamentos.

## Fases 6–8 — Consolidação MVP

- fluxo público estável (listagem + detalhe + lead);
- registo de venda no painel do corretor;
- área admin com políticas e guards.

## Fase 9 — Validação e produção-ready

- teste E2E automatizado (`MvpEndToEndTest`, `scripts/verify-mvp-e2e.php`);
- endurecimento de login e documentação de segurança (`docs/security.md`);
- LGPD: consentimento em lead + `docs/lgpd-retention.md`;
- guia de deploy e `compose.prod.yaml` de referência (`docs/deploy.md`).

## Fase 10+ — Evolução pós-MVP

- automação de pagamentos;
- integração com portais;
- IA para apoio comercial;
- melhorias de CRM;
- relatórios avançados.

## Regra de prioridade

Sempre priorizar o que valida este fluxo:

1. corretor publica imóvel;
2. comprador encontra;
3. lead é gerado;
4. venda é registrada;
5. revenue share é calculado.

## Marcos de validação (como saber que avançamos)

| Fase | Critério de saída | OK? |
| :--- | :--- | :--- |
| Fase 1 | `php artisan migrate` roda sem erros | ✅ |
| Fase 2 | Corretor publica imóvel com foto | ✅ |
| Fase 3 | Comprador envia lead e corretor vê no painel | ✅ |
| Fase 4 | Venda registrada e split calculado | ✅ |
| Fase 5 | Admin vê faturamento no dashboard | ✅ |
| Fase 6–8 | Fluxo MVP manual de ponta a ponta | ✅ |
| Fase 9 | `php scripts/verify-mvp-e2e.php` passa; docs segurança/deploy/LGPD | ✅ |
