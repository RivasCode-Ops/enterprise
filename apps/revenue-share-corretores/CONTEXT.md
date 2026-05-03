# CONTEXT.md
## Revenue Share Corretores — Contexto do Produto

---

## Propósito

Plataforma onde corretores publicam imóveis gratuitamente e pagam à plataforma somente quando a venda é concretizada (revenue share de 20% sobre a comissão do corretor).

---

## Problema que resolve

Corretores de imóveis (inicialmente no Piauí) enfrentam:
- Mensalidades caras de plataformas tradicionais, mesmo sem vender
- Ferramentas fragmentadas (anúncios, leads, CRM, financeiro em lugares separados)

---

## Público-alvo

- **Corretor:** publica imóveis, recebe leads, gerencia vendas
- **Comprador:** busca imóveis, entra em contato com corretor (sem cadastro obrigatório)
- **Admin:** acompanha corretores, vendas e faturamento

---

## MVP entregue (Fases 1–5)

| Fase | Descrição | Status |
| :--- | :--- | :--- |
| 1 | Ambiente + migrations base | ✅ |
| 2 | Publicação de imóveis (CRUD + upload de fotos) | ✅ |
| 2 UI | Formulário + listagem para corretor | ✅ |
| 3 | Leads + dashboard de leads (comprador → corretor) | ✅ |
| 4 | Vendas + revenue share (cálculo automático) | ✅ |
| 5 | Admin dashboard (KPIs, corretores, pagamentos) | ✅ |

**Fases 6–9 (roadmap):** fluxo público → lead (com consentimento) → venda/split → admin com políticas e guards; teste E2E (`MvpEndToEndTest.php` + script de verificação); documentação segurança, deploy e LGPD — **concluídas**. Detalhe em [`docs/roadmap.md`](docs/roadmap.md).

**Detalhamento das entregas:**
- Autenticação com guards separados (`broker`, `admin`)
- Busca pública de imóveis com filtros
- URLs públicas por slug (`/properties/{slug}`)
- Rate limiting em leads (IP + email/imóvel/24h) e nos logins (middleware + `RateLimiter`)
- LGPD: consentimento obrigatório no envio de lead; política de retenção documentada
- Deploy no Railway (Nixpacks + `railway.toml`, sem seed automático no start)
- Idioma: `APP_LOCALE=pt_BR`, traduções em `lang/pt_BR/` (ex.: `auth.php`)

---

## Stack utilizada

| Camada | Tecnologia |
| :--- | :--- |
| Backend | PHP 8.2+ / Laravel 11 |
| Frontend | Livewire v3 + Alpine.js + Tailwind CSS |
| Banco | PostgreSQL 15 |
| Cache/Filas | Redis (opcional; sessão/cache podem usar `database`) |
| Deploy | Railway (Nixpacks + `railway.toml`) |

---

## Fora do escopo (pós-MVP)

- App mobile nativo
- Integração com portais (Zap, Viva Real, OLX)
- Chat em tempo real (WebSockets)
- Split automático via gateway (ex.: Stripe Connect, Asaas)
- IA de precificação avançada
- Tour virtual 3D

---

## Estado atual (alinhado com código)

- **Código:** funcional para o MVP e marcos do roadmap até à Fase 9
- **Testes:** E2E em `tests/Feature/MvpEndToEndTest.php`; script `php scripts/verify-mvp-e2e.php` quando o PHP estiver disponível no ambiente
- **Documentação:** índice em [`docs/README.md`](docs/README.md); guias `deploy`, `security`, `database`, `architecture`, `roadmap`, `decisions`, `lgpd-retention`, `local-setup-windows`, etc.
- **UI / cópia:** pt-BR nas áreas principais (formulários admin/corretor, leads, mensagens de rate limit)
- **Deploy:** Railway documentado; seed manual apenas quando necessário (demo / smoke test)
- **Monorepo:** política de vulnerabilidades em [`SECURITY.md`](../../SECURITY.md) (raiz `enterprise`)

### Observação sobre o modelo de dados

A entidade `buyers` existia só no modelo conceitual; no MVP os dados do comprador estão em `leads`. Ver secção dedicada em [`docs/database.md`](docs/database.md).

### Repositório

A pasta local de backup `apps/.rsc-phase1-backup/` está ignorada no `.gitignore` da raiz do monorepo — não versionar.

---

## Documentos relacionados

- [`HANDOFF.md`](HANDOFF.md) — continuidade do desenvolvimento
- [`README.md`](README.md) — visão do produto
- [`docs/README.md`](docs/README.md) — índice da documentação técnica
- [`docs/roadmap.md`](docs/roadmap.md) — fases e marcos
- [`docs/deploy.md`](docs/deploy.md) — deploy no Railway
- [`docs/database.md`](docs/database.md) — modelo de dados
- [`docs/decisions.md`](docs/decisions.md) — decisões arquiteturais
- [`docs/security.md`](docs/security.md) — segurança e LGPD (app)

---

## Próximos passos (pós-MVP)

1. **Produção:** confirmar variáveis no Railway, domínio/TLS, `APP_URL`, e evitar contas demo em ambiente com utilizadores reais
2. **Validação** com corretores reais (Piauí / região inicial)
3. **Feedback** e priorização de melhorias (CRM, relatórios, verificação de email, reset de senha, etc.)
4. **Iterações** com base em uso real e métricas
