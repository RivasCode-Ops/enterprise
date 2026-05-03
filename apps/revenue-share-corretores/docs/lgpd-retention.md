# LGPD — retenção e bases legais (rascunho operacional)

Documento interno para alinhar produto e jurídico **antes** de tratamento de dados pessoais em escala. Não substitui parecer jurídico.

## Dados tratados no MVP

- **Leads (compradores):** nome, email, telefone opcional, mensagem, consentimento e timestamp de aceite (`consent_privacy_accepted`, `consent_accepted_at`).
- **Corretores:** dados de conta e imobiliária (nome, email, telefone, empresa).
- **Administradores:** conta para acesso ao painel.

## Base legal sugerida

- **Leads:** execução de medidas pré-contratuais a pedido do titular (contacto sobre imóvel), com **consentimento** explícito no formulário onde aplicável.
- **Corretores/admin:** execução de contrato ou relação precontratual / legítimo interesse administrativo da plataforma (ajustar com jurídico).

## Retenção (proposta de trabalho)

| Categoria | Retenção sugerida | Após o prazo |
| :--- | :--- | :--- |
| Leads sem negócio fechado | 24 meses após último contacto | Anonimizar ou apagar identificadores diretos |
| Leads com venda registada | Duração do contrato + 5 anos (contabilidade/fiscal — validar jurisdição) | Arquivo mínimo necessário |
| Logs de acesso | 90 dias | Eliminação rotativa |

Estes prazos são **editáveis**; implementação técnica futura: comandos `artisan` de purge e política de backup.

## Direitos do titular

- Acesso, retificação, eliminação, portabilidade (quando aplicável), oposição e informação sobre tratamento.
- Canal de pedido: email institucional a definir em `config`/site público.

## Transferências

- Se usar hospedagem fora do Brasil/UE, documentar cláusulas contratuais e localização dos dados no `docs/security.md` e contratos com subempreiteiros.

## Formulário de lead

O checkbox de consentimento na ficha do imóvel referencia este ficheiro; manter texto e política sincronizados com o site/app.
