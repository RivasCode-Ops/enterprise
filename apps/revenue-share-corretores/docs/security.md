# Segurança (MVP)

**Reporte responsável de vulnerabilidades:** política do repositório em [`SECURITY.md`](../../../SECURITY.md) (raiz do monorepo).

Este documento resume o estado atual e recomendações para endurecer o sistema antes de produção com tráfego real.

## Estado atual (MVP)

- **Sessões separadas:** guards `broker` e `admin` com providers distintos na mesma tabela `users`, controlados por `role` e middleware `admin.role`.
- **Proteção CSRF:** formulários e Livewire seguem o stack Laravel (tokens de sessão).
- **Rate limiting:**
  - Formulário público de lead (`PropertyShow`): limite por IP e por email+imóvel (24 h).
  - Login corretor e admin: `RateLimiter` por email+IP (10 falhas / janela) + middleware `throttle:20,1` nas rotas de página de login.
- **Política de admin:** `UserPolicy::accessAdminPanel` aplicada nos componentes Livewire da área admin.
- **Passwords:** hashing padrão do Laravel (`bcrypt` / config `hashing`).

## Sanctum / API

O MVP é **server-rendered (Livewire)**; não há API REST pública. **Laravel Sanctum** é recomendável se forem expostos endpoints SPA/mobile ou webhooks autenticados por token. Até lá, manter superfície só em rotas web com sessão reduz a necessidade imediata.

## Password reset e verificação de email

- **Reset de password:** não está exposto na UI do MVP; em produção, ativar `ForgotPasswordController` / fluxo Breeze ou Fortify e configurar `MAIL_*` para envio real.
- **Verificação de email:** o modelo `User` pode implementar `MustVerifyEmail` e proteger rotas com `verified`; hoje o factory marca emails como verificados em testes. Para produção, exigir verificação para contas de corretor antes de publicar imóveis.

## Cabeçalhos e HTTPS

Em produção, terminar TLS no proxy (Railway, Render, Caddy, NGINX) e definir `APP_URL` com `https://`. Considerar middleware para `Strict-Transport-Security`, `X-Frame-Options`, `X-Content-Type-Options` (pacote `laravel/framework` ou servidor).

## Segredos e `.env`

- Nunca commitar `.env` com credenciais reais.
- Rotação de `APP_KEY` só com consciência de invalidar sessões/cookies encriptados.

## Auditoria futura

- Logs de ações sensíveis (login admin, alteração de pagamentos).
- 2FA para contas admin em fase pós-MVP.
