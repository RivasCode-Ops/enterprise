# Fase 2 — Corretores e publicação de imóveis

## Estado (domínio + BD)

Implementado no repositório:

- Migrations `brokers`, `properties`, `property_images` + models Eloquent e relações (`User` → `Broker` → `Property` → `PropertyImage`).
- Seeder `BrokerPropertyDemoSeeder`: 1 broker (`corretor@demo.local`), 1 imóvel, 3 imagens em disco (`storage/app/public/properties/{id}/`) + registos na tabela `property_images`.
- Verificação rápida: `php scripts/verify-phase2.php` (esperado: imprime `1` e exit 0).

Comandos: `php artisan migrate` + `php artisan db:seed` (ou `./vendor/bin/sail artisan …` no WSL).

## Pré-requisitos

- Fase 1 validada (`docs/local-setup-windows.md` §9) no teu ambiente, quando usares Sail nativo.
- Documentos: `docs/database.md`, `docs/architecture.md`, `docs/decisions.md`.

## Âmbito restante (UI)

- cadastro de corretor via UI (hoje só dados + seeder);
- formulário publicação imóvel + upload real (validação MIME/tamanho);
- listagem e página de detalhe do imóvel no browser.

## Ordem técnica sugerida (próximas sessões)

1. Policies: corretor só gere os seus imóveis.
2. Rotas Livewire ou controllers + Blade + `storage:link` para servir fotos.
3. Substituir placeholders do seeder por fluxo autenticado.

## Fora desta fase

- Busca avançada e leads (Fase 3); vendas e split (Fase 4).
