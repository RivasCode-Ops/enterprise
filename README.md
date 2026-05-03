# enterprise

Repositório base da Riva's Tech para organizar documentação, padrões e desenvolvimento de produtos digitais. Cada aplicação vive em `apps/<nome>/` com o seu próprio `README`, `CONTEXT` e documentação de execução.

## Stack e tecnologias (por produto)

O monorepo agrega várias stacks. O produto em destaque hoje:

| Produto | Backend | Frontend | Dados / infra |
|--------|---------|----------|----------------|
| [`revenue-share-corretores`](apps/revenue-share-corretores/) | Laravel 11 | Livewire, Alpine, Tailwind | PostgreSQL, Redis; deploy documentado (ex.: Railway) |

Outros directórios em `apps/` seguem a stack descrita no `README.md` de cada um.

## Como rodar localmente

Não há um único `npm install` na raiz: entra na pasta do produto e segue o guia desse app.

**Exemplo — imóveis / revenue share:**

```bash
cd apps/revenue-share-corretores
# Ver README e docs do app: composer, .env, Sail ou PHP local
```

- Detalhes e alternativas (Sail, Windows): [`apps/revenue-share-corretores/docs/local-setup-windows.md`](apps/revenue-share-corretores/docs/local-setup-windows.md)  
- Testes MVP: `php scripts/verify-mvp-e2e.php` (com PHP e dependências do app instalados)

## Padrões importantes

- Branch principal: `main`.
- Commits: mensagens claras (em português, se for convenção da equipa); PRs pequenos e revistos.
- Documentação viva por produto: `CONTEXT.md`, `HANDOFF.md` em `apps/<produto>/` quando existirem.
- Monorepo: evitar misturar alterações não relacionadas no mesmo commit quando possível.

## Uso com agentes de IA

Este repositório está alinhado a fluxos com agentes:

- **Estado e continuidade:** `CONTEXT.md` e `HANDOFF.md` **por produto** (ex.: `apps/revenue-share-corretores/`), mais [modelo de handoff](docs/HANDOFF-template.md) em `docs/`.
- **Método e prompts:** [`ai-kit/`](ai-kit/) (copy, sessão, catálogo) e [`Cursor.md`](Cursor.md) na raiz para sessões no Cursor.
- **Estrutura e regras:** [documentação da estrutura do projeto](docs/estrutura-projeto.md), regras em [`.cursor/`](.cursor/) e skills em [`.agents/`](.agents/) **quando existirem** no clone.

Fluxo sugerido ao abrir uma sessão com agente:

1. Ler este `README.md` e o `README` / `CONTEXT` do app em que vai trabalhar.
2. Se for continuação, ler o `HANDOFF` desse app.
3. Usar o prompt adequado ([`ai-kit/Prompts.md`](ai-kit/Prompts.md) como índice) e o skill ou regra correspondente.

## Estrutura

| Área | Função |
|------|--------|
| `commercial/` | Contratos, propostas, manuais e documentos de LGPD |
| `apps/` | Cada produto ou sistema da Riva's Tech |
| `docs/` | Arquitetura, padrões e notas ([estrutura do projeto](docs/estrutura-projeto.md), [modelo de handoff](docs/HANDOFF-template.md)) |
| `ai-kit/` | Biblioteca de prompts e copies operacionais |
| `.cursor/` | Regras do Cursor |
| `.agents/` | Skills e fluxos com IA |

## Projeto atual

- `apps/revenue-share-corretores/` — plataforma imobiliária com modelo revenue share.

## Objetivo

Padronizar documentação, contexto, segurança e forma de desenvolvimento entre os produtos da Riva's Tech.

## Comunidade

Participação neste repositório está sujeita ao [Código de Conduta](CODE_OF_CONDUCT.md).

Para contribuir com código ou documentação, siga o [Guia de contribuição](CONTRIBUTING.md).

Para reportar uma vulnerabilidade de forma responsável (sem issue ou PR públicos), siga [SECURITY.md](SECURITY.md).

## Licença

Este repositório está licenciado sob a [MIT License](LICENSE) (Copyright (c) 2026 Rivaldo Alexandre), salvo indicação em contrário em subpastas ou dependências de terceiros.
