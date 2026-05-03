# HANDOFF.md

**MVP: ✅ Testado + deploy pronto** — fluxo publicação → lead (com consentimento LGPD) → venda 500k @ 5% → split → admin verificado via `tests/Feature/MvpEndToEndTest.php` e `php scripts/verify-mvp-e2e.php`. Guias iniciais: `docs/security.md`, `docs/deploy.md`, `docs/lgpd-retention.md`; stack de referência VPS: `compose.prod.yaml`.

**Deploy: ✅ Railway production** — `package-lock.json` versionado na app; procedimento em `docs/deploy.md` (§ Railway): GitHub → Root `apps/revenue-share-corretores`, Postgres + Redis, variáveis (`DATABASE_URL`, `REDIS_URL`, `APP_KEY`, `APP_ENV=production`), build `composer … --optimize-autoloader` + `npm ci` + `npm run build`, health `/`. Colar URL pública no § «URL de produção» do doc após o primeiro deploy; remover seed/demo quando sair do MVP.

## Fase 1: ✅ Completa Sail nativo WSL

**Repo + procedimento:** Ubuntu 22.04 (WSL2), script `scripts/wsl-ubuntu-sail-bootstrap.sh`, `.env` com Sail padrão (`APP_PORT=80`), docs §8–9 em `docs/local-setup-windows.md`, contorno **:9888** removido.

**Validação na tua máquina (marco roadmap):** no terminal Ubuntu, seguir **§9** — `./vendor/bin/sail artisan migrate` sem erros e `curl -I http://localhost` com resposta OK na **:80** (libertar porta se outro Docker a usar). **Fallback** se o build `laravel.test` falhar: §9-B (`docker compose` + contentor `php:8.2-cli` para migrate).

**Nota:** invocações `wsl` a partir do Cursor podem não terminar até existir utilizador criado no primeiro arranque do Ubuntu.

**Build `laravel.test` no Windows:** pode falhar (rede/PPA); não bloqueia o fluxo **Sail no Ubuntu** (ver §7–8).

## Fase 2 UI: ✅ Form + listagem

- **Rotas:** `/broker/login` (guest), `POST /broker/logout`, `/broker/properties` (guard `broker` — `auth:broker`).
- **Livewire:** `BrokerLogin`, `BrokerProperties` (cards + modal), `PropertyForm` (`WithFileUploads`, create/edit).
- **Storage:** ficheiros em `storage/app/public/properties/{id}/`; correr **`php artisan storage:link`** (Sail ou contentor `php:8.2-cli` na rede do projeto).
- **Demo:** `corretor@demo.local` / `password` — publicar imóvel com fotos; miniaturas e ligação «abrir em /storage/» na listagem.

## Fase 3: ✅ Leads gerados + dashboard corretor

- **Migrations:** `leads` (`property_id`, `buyer_name`, `buyer_email`, `buyer_phone`, `message`); `properties.slug` (único, backfill).
- **Model:** `Lead` → `Property`; listagem pública só imóveis `published` (binding por `slug`).
- **Público:** `GET /` → `PublicHome` (listagem); `GET /properties/{slug}` → `PropertyShow` — formulário de lead + flash de sucesso.
- **Anti-abuso (simples):** `RateLimiter` por IP (20 tentativas / 2 min) + **1 lead / email / imóvel / 24 h** (mesma chave).
- **Corretor:** `GET /broker/leads` → `BrokerLeads` (tabela); atalho «Ver leads» no header e em **BrokerProperties**.
- **Teste:** imóvel demo em **`/properties/apartamento-demo`** (após `db:seed` com `BrokerPropertyDemoSeeder`) → enviar lead → login corretor → **Ver leads**.

## Fase 4: ✅ Registro vendas + split

- **Migrations:** `sales` (`lead_id` único, `sale_value`, `split_percent`, `revenue_broker` calculado no modelo); `payments` (`sale_id`, `amount`, `due_date`, `status` `pending`/`paid`).
- **Models:** `Sale` (evento `saving` → `revenue_broker = valor × split / 100`), `Payment`; `Lead::sale()`.
- **UI:** **Leads** — botão «Registrar venda» + modal (valor, % split) → cria `Sale` + `Payment` pendente (vencimento +30 dias); **Vendas** (`/broker/sales`) — lista vendas + tabela de pagamentos pendentes.
- **Seeder:** `BrokerPropertyDemoSeeder` cria lead `comprador-venda-demo@local` + venda **R$ 500.000** a **5%** → revenue **R$ 25.000** + pagamento pendente.
- **Teste manual:** outro lead → «Registrar venda» 500000 e 5% → confirmar em **Vendas** revenue 25k.

## Fase 9: ✅ Validação E2E + segurança/deploy/LGPD

- **E2E:** `tests/Feature/MvpEndToEndTest.php` — imóvel publicado → lead com `buyer_consent` → login corretor → venda 500000 / 5% → revenue 25000 → login admin → `AdminDashboard`; correr `php scripts/verify-mvp-e2e.php` (PHPUnit + SQLite `:memory:` via `phpunit.xml`).
- **Login:** `RateLimiter` em `BrokerLogin` / `AdminLogin`; `throttle:20,1` nas rotas `admin.login` e `broker.login`.
- **LGPD:** colunas `consent_privacy_accepted`, `consent_accepted_at` em `leads`; checkbox em `property-show`; política de retenção em `docs/lgpd-retention.md`.
- **Docs / deploy:** `docs/security.md`, `docs/deploy.md` (Railway, Render, VPS); `compose.prod.yaml` (Postgres + Redis referência).

## Fase 5: ✅ Admin dashboard completo

- **Users:** coluna `role` (`user` / `admin`); guard `admin` + middleware `admin.role` (`EnsureUserIsAdmin`).
- **Policy:** `UserPolicy::accessAdminPanel` — usado nos Livewire admin (`authorize`).
- **Rotas:** prefixo `/admin` — `login`, `logout`, **dashboard** (`/admin`), `brokers`, `payments`; só `role=admin`.
- **Livewire:** `AdminLogin`, `AdminDashboard` (KPIs + gráficos Tailwind: barras revenue 6 meses, barra pago/pendente), `AdminBrokers`, `AdminPayments` (filtro estado).
- **Seeder:** `AdminDemoSeeder` — `admin@demo.local` / `password`.
- **Redirects:** `bootstrap/app.php` envia guests não autenticados de `/admin*` para `admin.login`; utilizadores autenticados em páginas guest redirecionam conforme guard.

## Fase 2: ✅ Publicação imóveis (domínio + dados)

- **Migrations:** `brokers`, `properties`, `property_images` (`database/migrations/2026_05_03_*`).
- **Models:** `Broker`, `Property`, `PropertyImage`; `User::broker()`.
- **Seeder:** `BrokerPropertyDemoSeeder` — 1 utilizador `corretor@demo.local`, 1 broker, 1 imóvel, **3** `property_images` + ficheiros em `storage/app/public/properties/{id}/`.
- **Validação:** `php scripts/verify-phase2.php` → conta propriedades do primeiro broker **> 0** (exit 0).
- **Artisan (Sail ou fallback):** `php artisan migrate --force && php artisan db:seed --force` — neste ambiente usado contentor `php:8.2-cli` na rede Sail (`docs/local-setup-windows.md` §9-B).
## Ambiente base (sempre válido)

- **Docker Desktop** ativo; **PostgreSQL + Redis** do projeto via `compose.yaml` (`docker compose up -d pgsql redis` ou stacks subidas pelo Sail).
- **Laravel 11** na raiz do app; migrations default já aplicadas em PostgreSQL em sessão anterior.

## Status atual

Base Laravel 11 com Sail (compose); **MVP Fases 1–9** — fluxo público → leads (consentimento) → vendas/split → **admin** com KPIs e pagamentos; seeders demo corretor + admin (`admin@demo.local`); teste E2E automatizado e documentação segurança/deploy/LGPD.

## O que já foi feito

- pasta do app criada;
- `README.md` criado;
- `CONTEXT.md` criado;
- `HANDOFF.md` criado;
- pasta `docs/` com `README.md` (objetivo e documentos esperados);
- definição inicial do MVP registrada;
- plano de **ambiente local no Windows** documentado em `docs/local-setup-windows.md` (caminho recomendado, dependências, ordem, validação);
- **Laravel 11** + ficheiros Sail (`compose.yaml`, `vendor/`, etc.);
- **PostgreSQL + Redis** a correr via Docker Compose (projeto `revenue-share-corretores`);
- **migrations** default do Laravel aplicadas em PostgreSQL;
- ~~contentor auxiliar `php artisan serve` (:9888)~~ — removido em favor de Sail no WSL.
- **Fase 2 (dados):** migrations brokers/properties/property_images, models, `BrokerPropertyDemoSeeder`, script `scripts/verify-phase2.php`;
- **Fase 2 (UI):** Livewire (`BrokerLogin`, `BrokerProperties`, `PropertyForm`), guard `broker`, uploads para `storage/app/public/properties/{id}/`;
- **Fase 3:** `Lead`, `PublicHome`, `PropertyShow`, `BrokerLeads`, rotas públicas + `broker.leads.index`;
- **Fase 4:** `Sale`, `Payment`, registo de venda em **BrokerLeads**, dashboard **BrokerSales** (`broker.sales.index`), seeder venda demo;
- **Fase 5:** `role` em `users`, guard `admin`, `UserPolicy`, área `/admin` (**AdminDashboard**, **AdminBrokers**, **AdminPayments**), `AdminDemoSeeder`.
- **Fase 9:** consentimento LGPD em `leads` + formulário `PropertyShow`; rate limit extra em logins; `MvpEndToEndTest`, `scripts/verify-mvp-e2e.php`; `docs/security.md`, `docs/deploy.md`, `docs/lgpd-retention.md`, `compose.prod.yaml`, `docs/roadmap.md` atualizado.

## O que ainda falta

- (opcional) confirmar §9 no Ubuntu se ainda não correu `sail artisan migrate` + HTTP :80;
- políticas por recurso (ex.: `SalePolicy`) além de broker/admin guards e `UserPolicy::accessAdminPanel`;
- busca global e pipeline comercial avançado;
- UI de password reset / email verify (documentado em `docs/security.md`, não ligado no MVP);

## Próximo passo recomendado

1. Marcar pagamento como `paid` (ação admin ou corretor);
2. Notificações por email (lead, venda, pagamento recebido);
3. Export CSV / relatório mensal para produção.

## Decisões já tomadas

- stack principal: Laravel 11 + Livewire + Alpine + Tailwind + PostgreSQL + Redis;
- foco inicial no MVP;
- financeiro avançado e integrações externas ficam para depois;
- produto começa pelo fluxo imóvel + lead, não pelo financeiro.

### Ambiente local (Windows) — sessão de setup

- **Opções avaliadas:** (A) PHP + Composer no PATH do Windows; (B) Docker Desktop + WSL2 + desenvolvimento no WSL + Postgres/Redis via Laravel Sail.
- **Caminho recomendado para este projeto:** **(B)** — Docker Desktop (WSL2), terminal **Ubuntu no WSL**, PHP 8.2+ e Composer **no WSL**, PostgreSQL e Redis **via Sail** (alinhado à stack e ao uso de containers já previsto no repo).
- **Alternativa aceitável:** PHP + Composer no WSL com Postgres/Redis só em Docker (compose mínimo), sem Sail na app — desde que Docker Desktop + WSL2 estejam ativos.
- **Não recomendado como padrão:** apenas PHP nativo no Windows sem WSL/containers para Postgres e Redis — mais frágil e menos alinhado à documentação do produto.
- **Dependências e ordem de instalação:** ver tabela e passos numerados em `docs/local-setup-windows.md`.
- **Próximo passo operacional:** com Ubuntu no WSL, usar `./vendor/bin/sail` no caminho do projeto; ou repetir `docker compose build` / `docker compose up -d` quando o acesso ao PPA `ondrej/php` estiver estável.
- **Estado desta máquina (pós-Fase 1):** Docker Desktop operacional; WSL default continua a ser `docker-desktop` (sem Ubuntu dedicada) — desenvolvimento com **`docker compose`** + contentor `php:8.2-cli` pontual para `artisan` quando necessário.

## Observações

Sempre que uma sessão terminar com mudança importante, este arquivo deve ser atualizado com:

- o que foi feito;
- o que ficou pendente;
- decisões tomadas;
- próximo passo claro.
