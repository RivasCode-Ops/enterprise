# architecture.md

## Revenue Share Corretores

Este documento registra a visão arquitetural inicial do produto.

## Objetivo

Descrever a estrutura principal da aplicação, seus blocos centrais e como eles se relacionam no MVP.

## Visão geral

A aplicação será construída inicialmente como um monólito modular em Laravel, com interface web server-driven usando Livewire, persistência em PostgreSQL e uso de Redis para cache e filas.

## Blocos principais

- interface web;
- autenticação e perfis;
- gestão de imóveis;
- busca e filtros;
- leads e contato;
- CRM básico do corretor;
- financeiro inicial;
- administração.

## Estrutura lógica

### Interface web
Responsável por páginas, formulários, navegação e interação do usuário.

### Camada de aplicação
Responsável por casos de uso, regras de negócio e orquestração entre modelos, serviços e ações.

### Camada de dados
Responsável por persistência em PostgreSQL, relacionamentos e consultas.

### Camada de suporte
Responsável por filas, cache, notificações, logs e integrações futuras.

## Fluxo principal do MVP

1. corretor cria conta;
2. corretor cadastra imóvel;
3. comprador busca imóvel;
4. comprador envia contato;
5. corretor acompanha lead;
6. corretor registra venda;
7. sistema calcula o split manual.

## Decisões arquiteturais iniciais

- usar Laravel como núcleo do sistema;
- usar Livewire para acelerar entregas no MVP;
- usar PostgreSQL como banco principal;
- manter arquitetura simples no início;
- evitar microserviços no MVP.

## Evolução futura esperada

No futuro, esta arquitetura pode crescer para incluir:
- integrações com portais;
- pagamentos automatizados;
- IA para precificação;
- recomendações para compradores;
- APIs externas de bairro, mapa e dados complementares.

## Observação

Este documento descreve a arquitetura em nível alto. Detalhes de tabelas, fluxos e endpoints devem ficar em documentos próprios dentro de `docs/`.
