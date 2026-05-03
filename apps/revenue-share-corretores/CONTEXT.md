# CONTEXT.md

## Projeto

- Nome: revenue-share-corretores
- Tipo: plataforma imobiliária com modelo revenue share
- Empresa: Riva's Tech

## Propósito

Criar uma plataforma onde corretores publicam imóveis sem custo inicial e pagam apenas quando vendem, unificando anúncios, leads, CRM e controle financeiro em um único sistema.

## Problema que resolve

Hoje o corretor costuma usar ferramentas separadas para anúncio, atendimento, CRM e financeiro, além de pagar mensalidades mesmo sem vender. O produto busca reduzir esse atrito com um modelo mais alinhado ao resultado.

## Público principal

- Corretores de imóveis
- Pequenas imobiliárias
- Compradores interessados em imóveis

## Escopo do MVP

- cadastro e login;
- perfis básicos;
- cadastro de imóveis;
- upload de imagens;
- busca com filtros;
- formulário de contato;
- leads básicos;
- painel do corretor;
- registro manual de venda;
- cálculo do split.

## Fora do MVP

- app mobile nativo;
- integração com portais;
- chat em tempo real;
- split automático;
- IA avançada de precificação.

## Stack definida

- Laravel 11
- Livewire + Alpine.js
- Tailwind CSS
- PostgreSQL
- Redis

## Estado atual

Base Laravel 11 no app; PostgreSQL/Redis (Sail); **Fase 2 (dados):** tabelas `brokers` / `properties` / `property_images`, seeder demo com fotos em `storage`; ver `HANDOFF.md` e `docs/phase2-publicacao-imoveis.md`. WSL/Sail: guia §8–9.

Já existe:
- repositório base `enterprise`;
- pasta do app `apps/revenue-share-corretores/`;
- `README.md` do app;
- `HANDOFF.md`;
- pasta `docs/` com `README.md` (índice da documentação técnica);
- projeto **Laravel 11** com `compose.yaml` (pgsql + redis), `vendor/`, `.env`;
- **migrations** iniciais do framework executadas em PostgreSQL.

Ainda falta:
- validar `./vendor/bin/sail` no terminal Ubuntu (após bootstrap §8);
- modelar banco de dados inicial (domínio do produto).

## Próximo passo

1. Validar Fase 1 no Ubuntu (`docs/local-setup-windows.md` §9) se ainda não estiver feito;
2. **Fase 2 — UI:** CRUD imóvel + upload + páginas públicas (`docs/phase2-publicacao-imoveis.md`).

## Regra de foco

Construir primeiro o fluxo principal do negócio:

1. corretor entra;
2. publica imóvel;
3. comprador encontra;
4. lead é gerado;
5. corretor registra venda;
6. plataforma calcula o revenue share.
