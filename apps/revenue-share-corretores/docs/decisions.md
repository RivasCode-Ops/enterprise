# decisions.md

## Revenue Share Corretores

Este documento registra decisões técnicas e de produto já tomadas no projeto.

## Objetivo

Manter histórico curto e claro das decisões para evitar rediscutir os mesmos pontos sem necessidade.

## Decisões iniciais

### 1. Repositório base
O projeto vive dentro do repositório `enterprise`, que organiza padrões, documentação, apps, regras do Cursor e fluxos com IA.

### 2. Nome provisório do produto
O nome atual do produto é `revenue-share-corretores`, podendo ser alterado futuramente sem afetar a estrutura base do repositório.

### 3. Stack principal
A stack inicial definida é:
- Laravel 11
- Livewire + Alpine.js
- Tailwind CSS
- PostgreSQL
- Redis

### 4. Arquitetura inicial
O MVP será construído como monólito modular, sem microserviços e sem API separada no início.

### 5. Estratégia de produto
O foco inicial é validar publicação de imóveis, busca, geração de leads e registro manual de vendas antes de avançar no financeiro automatizado.

### 6. Escopo fora do MVP
Não entram no MVP:
- app mobile nativo;
- integração com portais;
- chat em tempo real;
- split automático;
- IA avançada.

### 7. Ambiente de desenvolvimento local (Windows)
O caminho padrão para desenvolver este app no Windows é **Docker Desktop (WSL2) + terminal Ubuntu no WSL**, com **PHP 8.2+ e Composer no WSL** e **PostgreSQL + Redis via Laravel Sail**. Detalhes, dependências, ordem de instalação e checklist de validação estão em `docs/local-setup-windows.md`. Alternativa aceitável: PHP/Composer no WSL com Postgres/Redis apenas em containers, sem Sail.

## Regra de atualização

Adicionar novas decisões sempre que uma escolha impactar:
- arquitetura;
- banco de dados;
- fluxo de negócio;
- stack;
- prioridade de roadmap.
