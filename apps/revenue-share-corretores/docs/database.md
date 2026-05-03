# database.md

## Revenue Share Corretores

Este documento registra a estrutura inicial de dados do produto.

## Objetivo

Definir as entidades principais do MVP e servir como referência inicial para migrations, models e relacionamentos.

## Entidades iniciais

- `users`
- `brokers`
- `buyers` — *apenas no modelo conceitual original; não existe como tabela no MVP* (ver nota abaixo)
- `properties`
- `property_images`
- `leads`
- `sales`
- `payments`

## Relações esperadas

- um `user` pode representar um corretor (e admin); no MVP o comprador não tem conta — dados de contacto ficam em `leads`;
- um `broker` pode ter muitos `properties`;
- um `property` pode ter muitas `property_images`;
- um `property` pode gerar muitos `leads`;
- um `broker` pode registrar muitas `sales`;
- uma `sale` pode gerar um ou mais `payments`.

## Esquema aplicado (MVP Fase 2)

| Tabela | Colunas principais |
|--------|---------------------|
| `brokers` | `user_id` (FK → `users`, único), `company_name`, `phone`, timestamps |
| `properties` | `broker_id` (FK), `title`, `description`, `price` (decimal 15,2), `city`, `state`, `address_line`, `status` (default `published`), timestamps |
| `property_images` | `property_id` (FK), `path` (caminho relativo ao disco `public`), `sort_order`, timestamps |

## Nota sobre a entidade `buyers` (MVP)

O modelo conceitual original previa uma tabela `buyers`. No código atual do MVP, optamos por **simplificar**: os dados do comprador (`buyer_name`, `buyer_email`, `buyer_phone`) são armazenados diretamente na tabela `leads`.

**Motivo:** Redução de complexidade no MVP, já que o comprador não precisa de conta própria nem de histórico de leads.

**Caso necessário no futuro:** Criar tabela `buyers` e associar leads aos registos (ex.: `leads.buyer_id` → `buyers.id`), migrando os dados existentes.

## Observações

Esta estrutura é inicial e pode ser refinada conforme a modelagem do banco e as regras do negócio forem ficando mais claras.
