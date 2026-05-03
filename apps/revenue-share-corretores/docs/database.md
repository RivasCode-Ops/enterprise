# database.md

## Revenue Share Corretores

Este documento registra a estrutura inicial de dados do produto.

## Objetivo

Definir as entidades principais do MVP e servir como referência inicial para migrations, models e relacionamentos.

## Entidades iniciais

- `users`
- `brokers`
- `buyers`
- `properties`
- `property_images`
- `leads`
- `sales`
- `payments`

## Relações esperadas

- um `user` pode representar um corretor ou comprador;
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

## Observações

Esta estrutura é inicial e pode ser refinada conforme a modelagem do banco e as regras do negócio forem ficando mais claras.
