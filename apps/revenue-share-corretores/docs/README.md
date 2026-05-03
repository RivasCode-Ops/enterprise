# docs/ — Documentação técnica do produto

## Revenue Share Corretores

Centraliza documentos técnicos do produto que não devem ficar espalhados no `README.md`, `CONTEXT.md` ou `HANDOFF.md`.

---

## Índice de documentos

| Documento | Descrição |
| :--- | :--- |
| [`deploy.md`](deploy.md) | Instruções de deploy no Railway (variáveis, seed, healthcheck) |
| [`security.md`](security.md) | Políticas de segurança, LGPD e rate limiting |
| [`lgpd-retention.md`](lgpd-retention.md) | Política de retenção de dados e consentimento |
| [`database.md`](database.md) | Modelo de dados (entidades, relacionamentos) |
| [`architecture.md`](architecture.md) | Visão geral da arquitetura (Laravel + Livewire + PostgreSQL) |
| [`decisions.md`](decisions.md) | Decisões arquiteturais registradas (ADRs) |
| [`roadmap.md`](roadmap.md) | Fases do projeto (1 a 9, com marcos de validação) |
| [`phase2-publicacao-imoveis.md`](phase2-publicacao-imoveis.md) | Especificação da Fase 2 (publicação de imóveis) |
| [`local-setup-windows.md`](local-setup-windows.md) | Configuração do ambiente de desenvolvimento no Windows |

---

## Regra de uso

- Mantenha este índice atualizado ao adicionar novos documentos
- Prefira links relativos entre documentos (`[deploy.md](deploy.md)`)
- Documentos obsoletos devem ser movidos para `archive/` ou removidos
