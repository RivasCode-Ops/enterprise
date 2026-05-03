# Deploy (guia inicial)

Este guia descreve opções para colocar a app em produção. Ajustar versões de PHP (8.2+) e Node conforme `composer.json` / `package.json`.

## Pré-requisitos comuns

- Base de dados **PostgreSQL** (alinhado ao `compose.yaml` / `compose.prod.yaml`).
- **Redis** opcional (recomendado para cache/sessão em escala; o MVP funciona com `CACHE_STORE` / `SESSION_DRIVER` em `database` se não configurares Redis).
- `php artisan storage:link` para URLs `/storage` (imagens de imóveis).
- Variáveis: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://…`, credenciais de BD e mail.

---

## Railway (MVP — repo `enterprise`, app em monorepo)

Este fluxo assume o repositório GitHub **enterprise** (mono-repo) com a aplicação Laravel em **`apps/revenue-share-corretores`**. O ficheiro [`railway.toml`](../railway.toml) na pasta da app define **Nixpacks**, build, start e **healthcheck em `/`**.

Se o repositório Git for **só** esta app (Laravel na raiz do clone), deixa **Root Directory** vazio e mantém o `railway.toml` na raiz do repositório.

### 0. Commit Git (antes de ligar o Railway)

Garante que o **`package-lock.json`** e o `railway.toml` estão no remoto para builds reproduzíveis (`npm ci`). Na raiz do mono-repo **enterprise**:

```bash
git add apps/revenue-share-corretores/package-lock.json \
        apps/revenue-share-corretores/railway.toml \
        apps/revenue-share-corretores/docs/deploy.md \
        apps/revenue-share-corretores/HANDOFF.md
git commit -m "chore(railway): lockfile + deploy config for MVP production"
git push origin main
```

(Ajusta o nome da branch se não for `main`.)

### 1. Novo projeto e código

1. Em [railway.app](https://railway.app), **New Project** → **Deploy from GitHub repo**.
2. Autoriza a organização e escolhe o repositório **enterprise** (ou o nome real do mono-repo).
3. O Railway cria um primeiro serviço; renomeia-o para algo como `revenue-share-web`.

### 2. Serviço Web — raiz do build (crítico em monorepo)

1. Abre o serviço → **Settings**.
2. Em **Root Directory**, define: `apps/revenue-share-corretores`  
   (caminho relativo à raiz do clone Git; sem barra inicial.)
3. Em **Config as code** (se aparecer), confirma que o ficheiro usado é o `railway.toml` **dentro** dessa pasta (por defeito o Railway procura `railway.toml` na root do serviço, ou seja, na mesma pasta após o Root Directory).

### 3. Postgres e Redis (produção)

1. No projeto, **New** → **Database** → **Add PostgreSQL** (base de produção).
2. **New** → **Database** → **Add Redis** (stack MVP; sessão/cache podem usar Redis — ver tabela de variáveis).
3. No serviço **Web**, separador **Variables** → **Add variable reference** (ou equivalente):
   - `DATABASE_URL` a partir do Postgres (`${{NomeDoServicoPostgres.DATABASE_URL}}` — o nome do serviço é o que aparece no canvas do projeto).
   - `REDIS_URL` a partir do Redis (`${{NomeDoServicoRedis.REDIS_URL}}`).

### 4. Variáveis de ambiente (serviço Web)

| Variável | Valor / notas |
| :--- | :--- |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | Gera localmente: `php artisan key:generate --show` e cola o valor **uma vez** (nunca commits). |
| `APP_URL` | `https://${{RAILWAY_PUBLIC_DOMAIN}}` (referência ao domínio público do próprio serviço) ou o URL HTTPS completo depois do primeiro deploy. |
| `DB_CONNECTION` | `pgsql` (**obrigatório** — o default local do projecto é `sqlite`.) |
| `DB_URL` | Opcional se `DATABASE_URL` já estiver definida: o Laravel usa `DB_URL` ou, em falta, `DATABASE_URL` na ligação `pgsql` (`config/database.php`). Podes duplicar referência: `DB_URL` = mesma referência que `DATABASE_URL`. |
| `DATABASE_URL` | Injetada pelo Postgres (referência Railway). |
| `REDIS_URL` | Referência ao plugin Redis (obrigatório se adicionaste Redis). |
| `CACHE_STORE` | `redis` (recomendado com `REDIS_URL`). |
| `SESSION_DRIVER` | `redis` (recomendado com `REDIS_URL`; senão mantém `database`.) |
| `LOG_CHANNEL` | `stderr` ou `stack` (útil em PaaS). |

Credenciais demo (apenas depois de `php artisan db:seed --force`): `admin@demo.local` / `password` e `corretor@demo.local` / `password` — **não usar em produção final com clientes reais.**

### 5. Build e start (automático via `railway.toml`)

- **Build (passos efectivos, uma linha no Nixpacks):**
  1. `composer install --no-dev --optimize-autoloader --no-interaction`
  2. `npm ci`
  3. `npm run build`
- **Start (produção):** `migrate --force` + `storage:link` + `php artisan serve` na porta `$PORT` — **sem** `db:seed` em cada arranque (dados demo só quando necessário; ver § abaixo).

Se alterares comandos, edita [`railway.toml`](../railway.toml) ou os overrides no painel **Settings → Build / Deploy**.

#### Seed opcional (demo / teste E2E no URL público)

Para ter imóvel `apartamento-demo` e utilizadores demo **uma vez** no Postgres de Railway:

1. Serviço Web → **Deployments** → menu do pod → **Shell** (ou Railway CLI).
2. Na shell do contentor (directório da app já definido pelo Root Directory):

```bash
php artisan db:seed --force
```

Isto corre `DatabaseSeeder` (corretor/admin demo). **Não uses em produção final** com utilizadores reais — apenas smoke test ou staging.

### Checklist rápido — `RivasCode-Ops/enterprise` → Railway produção

| Passo | Acção |
| :--- | :--- |
| Repo | GitHub `https://github.com/RivasCode-Ops/enterprise` |
| Root Directory | `apps/revenue-share-corretores` |
| Serviços | Postgres + Redis ligados ao Web; variáveis `DATABASE_URL`, `REDIS_URL` |
| Segredo | `APP_KEY` (local: `php artisan key:generate --show`), **nunca** no Git |
| App | `APP_ENV=production`, `APP_DEBUG=false`, `DB_CONNECTION=pgsql`, `APP_URL=https://…`, `CACHE_STORE=redis`, `SESSION_DRIVER=redis` |
| Deploy | Push em `main` → build OK → health `/` = 200 |
| E2E URL | Após seed opcional: abrir `https://<teu-dominio>/properties/apartamento-demo` e fluxo §10 |

### 6. Nixpacks / deteção Laravel

Com **Root Directory** correcto, o Nixpacks detecta **PHP + Composer + Node** (há `composer.json` e `package.json`). O `railway.toml` força o **buildCommand** acima. Não coloques um `Dockerfile` na pasta da app a menos que queiras substituir todo o fluxo Nixpacks.

### 7. Healthcheck

No [`railway.toml`](../railway.toml): `healthcheckPath = "/"` (página inicial do MVP deve responder **200**). Alternativa Laravel nativa: rota `/up` (definida em `bootstrap/app.php`); podes mudar `healthcheckPath` para `/up` se preferires health sem HTML.

### 8. Domínio e TLS

Após o primeiro deploy bem-sucedido, em **Settings → Networking** gera domínio `*.up.railway.app` ou liga domínio próprio. Garante `APP_URL` com `https://` coerente com esse domínio.

### 9. URL de produção (preencher após deploy)

Substitui o placeholder pelo domínio gerado em **Settings → Networking** (ex. `https://revenue-share-web-production-xxxx.up.railway.app`):

| Campo | Valor |
| :--- | :--- |
| **URL pública HTTPS** | `https://________________________.up.railway.app` |

Cola o mesmo valor em `APP_URL` (ou mantém a referência `${{RAILWAY_PUBLIC_DOMAIN}}` com prefixo `https://`).

### 10. Validação E2E (fluxo MVP completo)

Ordem sugerida (com seed activo no start: imóvel demo + utilizadores demo):

1. **Healthcheck:** `GET /` → **200**.
2. Imóvel demo: `https://<URL §9>/properties/apartamento-demo`.
3. **Lead:** enviar formulário (inclui consentimento LGPD).
4. **Corretor:** `https://<URL §9>/broker/login` — `corretor@demo.local` / `password` → **Leads** → registar **venda** (ex. valor + split coerente com o teste local).
5. **Admin:** `https://<URL §9>/admin` (após login `admin@demo.local` / `password`) — dashboard com **revenue** / pagamentos alinhados à venda.

### 11. Screenshots (capturas para wiki / onboarding)

Não incluímos binários PNG no repositório; usa a tabela abaixo para exportar figuras para a tua documentação interna (ex.: Confluence / Notion).

| Figura | Onde no Railway | O que deve aparecer |
| :--- | :--- | :--- |
| 1 | Project → **New Project** → **Deploy from GitHub** | Repositório seleccionado e primeiro deploy em curso. |
| 2 | Serviço Web → **Settings → Root Directory** | Campo com `apps/revenue-share-corretores`. |
| 3 | Project → serviços **Postgres** + **Redis** | Plugins criados e “Connected” / variáveis visíveis. |
| 4 | Web → **Variables** | Linhas `APP_*`, `DB_CONNECTION=pgsql`, referências `DATABASE_URL` / `REDIS_URL`. |
| 5 | Web → **Settings → Networking** | Domínio `*.up.railway.app` ou domínio custom. |
| 6 | **Deployments** → último deploy → logs | Build `composer` + `npm ci` + `vite build` OK; start com `migrate` / `serve`. |
| 7 | Browser — URL final §9 | Home + `/properties/apartamento-demo` + admin dashboard (prova E2E). |

Guardar os PNG na wiki interna ou em `docs/images/railway/` (opcional, fora do Git se contiverem dados sensíveis).

Referência visual oficial: [Railway Docs — Deploy](https://docs.railway.com/guides/deployments) e [Variables](https://docs.railway.com/develop/variables).

### 12. Alternativa: VPS (DigitalOcean)

Ver secção mais abaixo e `compose.prod.yaml` (Postgres + Redis); PHP/HTTP fica à tua escolha (Forge, Coolify, NGINX + PHP-FPM).

---

## Render (resumo)

1. **Web Service** (Docker ou ambiente PHP).
2. **PostgreSQL** gerenciado; mapear `DATABASE_URL` ou `DB_*`.
3. Build: `composer install --no-dev --optimize-autoloader && npm ci && npm run build`.
4. Start: servidor HTTP adequado (não uses `artisan serve` em produção pesada).
5. Job único: `php artisan migrate --force`.

---

## VPS (DigitalOcean) com Docker

1. Droplet Ubuntu LTS com Docker e Docker Compose plugin.
2. Copiar código e `.env` de produção (ou CI).
3. `compose.prod.yaml` na raiz da app: Postgres + Redis em rede interna; acrescentar tier web.
4. Firewall: apenas 80/443 no proxy.
5. Cron: `* * * * * php artisan schedule:run`.
6. Worker: `php artisan queue:work` supervisionado.

---

## Validação local do MVP (antes do deploy)

```bash
php scripts/verify-mvp-e2e.php
```

Garante que o teste `MvpEndToEndTest` passa (SQLite em memória via `phpunit.xml`).
