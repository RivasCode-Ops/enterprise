# Start Session.md — Abertura operacional do ai-kit

Esta copy é o **atalho padrão** para iniciar uma sessão com IA usando o `ai-kit`.

Ela assume que:

- o projeto real tem sua própria documentação (README, CONTEXT, etc.);
- o `dokit` define o método universal;
- o `ai-kit` organiza os prompts por ferramenta.

Use esta copy quando você quiser começar rápido sem pensar qual prompt escolher.

---

## 1. Copy principal de start session (geral)

````md
Quero iniciar uma sessão com você usando a seguinte prioridade de contexto:

1. documentação viva do projeto (README, CONTEXT, HANDOFF, ROADMAP, etc.);
2. kit universal de método (`dokit`: AGENTS, CONTEXT, DECISIONS, FLUXO, HANDOFF, START-SESSION);
3. biblioteca de prompts (`ai-kit`: Copy, Session Copy, Cursor, Claude, Copilot, etc.).

Antes de fazer qualquer mudança ou recomendação:

1. identifique os arquivos que representam o estado real do projeto;
2. leia especialmente README, CONTEXT e HANDOFF se existirem;
3. use o `dokit` apenas como método (regras, fluxo, decisões), não como estado do projeto;
4. trate o `ai-kit` como apoio operacional de prompt, não como verdade absoluta.

Quero que você:

- resuma o estado atual do projeto em poucas linhas;
- resuma a tarefa desta sessão;
- proponha um plano curto e objetivo de execução;
- só então comece a sugerir código, ajustes ou decisões.

Regras:

- não mude stack, arquitetura ou fluxo principal sem destacar e justificar;
- não abra novas frentes fora do escopo atual;
- não trate templates ou prompts como se fossem documentação viva;
- mantenha coerência com padrões existentes no código e nos docs.

Ao final da sessão:

- resuma o que foi feito;
- liste pendências e próximos passos;
- aponte riscos ou dúvidas que ficaram em aberto;
- indique quais docs devem ser atualizados (CONTEXT, HANDOFF, DECISIONS, etc.).

Objetivo desta sessão:
[descreva aqui]
````

---

## 2. Versão curta (colar em qualquer ferramenta)

````md
Prioridade:

1. docs reais do projeto (README, CONTEXT, HANDOFF, etc.);
2. método do `dokit`;
3. prompts do `ai-kit` como apoio.

Antes de agir:
- leia o contexto vivo;
- resuma estado atual;
- resuma a tarefa;
- proponha plano curto.

Regras:
- não mude arquitetura/stack sem destacar;
- não abra novas frentes fora do escopo;
- não trate template como estado real;
- mantenha padrão já existente.

Ao final:
- resuma entregas, pendências, riscos e próximos passos;
- diga quais docs atualizar.

Objetivo:
[descreva aqui]
````

---

## 3. Versão específica para retomada

````md
Esta é uma sessão de retomada.

Use como prioridade:

1. HANDOFF e CONTEXT reais do projeto;
2. método do `dokit` (FLUXO, AGENTS, DECISIONS);
3. prompts do `ai-kit` apenas como apoio.

Antes de agir:
- leia o handoff e o contexto;
- resuma o ponto onde a sessão anterior parou;
- proponha um plano curto para concluir a pendência principal, sem abrir novas frentes.

Regras:
- não refatorar grandes áreas agora;
- manter foco na pendência principal até encerrar;
- explicar impactos de qualquer mudança sensível.

Ao final:
- atualizar o handoff lógico (resumo, pendências, próximos passos);
- indicar se o contexto geral mudou e onde deve ser atualizado.

Objetivo da retomada:
[descreva aqui]
````

---

## 4. Como usar na prática

- Sessão nova qualquer ferramenta → use a **copy principal** ou a **versão curta**.  
- Sessão de continuação (tem handoff) → use a **versão específica para retomada**.  
- Se estiver em Cursor/Claude/Copilot, você pode combinar:
  - esta `Start Session` + o arquivo específico da ferramenta (`Cursor.md`, `Claude.md`, `Copilot.md`).

**Neste monorepo:** `Cursor.md` está na raiz (`../Cursor.md`).

---

## 5. Gatilhos de atualização

Atualize este arquivo quando:

- a forma de iniciar sessões com o kit mudar;
- o `dokit/START-SESSION.md` ganhar regras novas relevantes;
- surgir uma nova ferramenta que precise de ajuste de abertura.

A função deste arquivo é ser **o start rápido do ai-kit**, sem discussão, só colar e trabalhar.
