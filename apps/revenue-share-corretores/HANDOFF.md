# HANDOFF — revenue-share-corretores

**Data de referência:** 2026-05-02 (atualizar ao fechar uma sessão relevante)

## Resumo executivo

- **MVP (Fases 1–9):** entregue — fluxo público → lead (consentimento LGPD) → venda + split → painel corretor + admin; E2E em `tests/Feature/MvpEndToEndTest.php`.
- **Documentação:** `CONTEXT.md` e `docs/README.md` (índice) alinhados ao estado do código; `docs/database.md` documenta a ausência de tabela `buyers` (dados do comprador em `leads`).
- **i18n / UI:** `APP_LOCALE=pt_BR` (ver `.env.example`); `lang/pt_BR/auth.php`; mensagens de rate limit e logins em pt-BR; label **Senha** no login admin.
- **Monorepo:** política de vulnerabilidades na raiz — [`SECURITY.md`](../../SECURITY.md); pasta local `apps/.rsc-phase1-backup/` **ignorada** no `.gitignore` do `enterprise` — não commitar.
- **Deploy:** Railway — Root Directory `apps/revenue-share-corretores`, `railway.toml` (migrate + `storage:link` + serve, **sem** seed no start); detalhe em `docs/deploy.md`.

---

## Mapa rápido (ficheiros críticos)

| Área | Onde |
| :--- | :--- |
| Contexto produto | `CONTEXT.md`, `README.md` |
| Índice docs técnicos | `docs/README.md` |
| Deploy / env | `docs/deploy.md`, `railway.toml`, `config/database.php` (`DB_URL` / `DATABASE_URL`) |
| Segurança / LGPD | `docs/security.md`, `docs/lgpd-retention.md` |
| Modelo de dados | `docs/database.md`, `database/migrations/` |
| Leads + consentimento | `app/Livewire/PropertyShow.php`, `resources/views/livewire/property-show.blade.php` |
| Login + throttle | `app/Livewire/BrokerLogin.php`, `AdminLogin.php`, `routes/web.php` (`throttle:20,1`) |
| E2E | `tests/Feature/MvpEndToEndTest.php`, `scripts/verify-mvp-e2e.php`, `phpunit.xml` (SQLite `:memory:`) |

---

## Como validar

```bash
cd apps/revenue-share-corretores
composer install
php artisan test
# ou, se existir no projeto:
php scripts/verify-mvp-e2e.php
```

**Smoke manual (após seed):** `php artisan db:seed --force` → `/properties/apartamento-demo` → lead → `/broker/login` (`corretor@demo.local` / `password`) → leads → registrar venda → `/admin` (`admin@demo.local` / `password`).

---

## Referência técnica por fase (compacta)

| Fase | Entrega principal |
| :--- | :--- |
| 1 | Laravel 11, Sail/compose, migrations base |
| 2 | `brokers`, `properties`, `property_images`; Livewire corretor (`BrokerLogin`, `BrokerProperties`, `PropertyForm`); storage `storage/app/public/properties/{id}/` + `storage:link` |
| 3 | `leads`, slug em `properties`; `PublicHome`, `PropertyShow`, `BrokerLeads`; rate limit leads (IP + email/imóvel/24h) |
| 4 | `sales`, `payments`; registo venda em leads; `BrokerSales` |
| 5 | `role` em `users`, guard `admin`, `UserPolicy`, `/admin` (dashboard, brokers, payments) |
| 6–9 | Políticas/guards; LGPD em `leads`; `MvpEndToEndTest`; docs segurança, deploy, LGPD; `compose.prod.yaml` referência |

**Credenciais demo (só dev/staging):** `corretor@demo.local` / `password`, `admin@demo.local` / `password` — não usar em produção com utilizadores reais.

---

## O que ficou explícito fora do MVP

- Reset de password / verificação de email na UI (ver `docs/security.md`).
- Políticas por recurso além de `UserPolicy::accessAdminPanel` (opcional).
- Integrações externas, split automático via gateway, app nativo.

---

## Próxima sessão sugerida (prioridade)

1. **Produção:** confirmar `APP_URL`, TLS, Redis/sessão; remover dependência de contas demo quando houver clientes reais.
2. **Produto:** marcar pagamento como `paid` com UX clara (admin ou corretor, conforme regra de negócio).
3. **Comunicação:** notificações por e-mail (lead, venda, pagamento) + `MAIL_*` em produção.
4. **Operação:** export CSV / relatório mensal (se prioridade de negócio).

---

## Observação para o próximo agente / dev

1. Ler **`CONTEXT.md`** e este **`HANDOFF.md`** antes de alterar código.
2. Manter **`docs/README.md`** atualizado ao criar documentos novos em `docs/`.
3. Ao terminar trabalho relevante: atualizar **HANDOFF** (resumo + próximo passo) e, se necessário, **CONTEXT** (estado / roadmap).

---

## Histórico de ambientes (Windows / WSL)

Caminho recomendado: Docker Desktop (WSL2), desenvolvimento no Ubuntu WSL, PHP/Composer no WSL, PostgreSQL/Redis via Sail — `docs/local-setup-windows.md` (§8–9). Fallback: `docker compose` + contentor `php:8.2-cli` para `artisan` quando o Sail não subir.
