# Prompts.md — Catálogo do ai-kit

Este arquivo é o **índice dos prompts** do `ai-kit`.

Ele responde rápido a três perguntas:

- “Que prompts eu tenho?”
- “Para que situação serve cada um?”
- “Qual devo usar agora?”

---

## 1. Visão geral dos prompts

| Arquivo | Tipo | Uso principal |
|---------|------|---------------|
| `Copy.md` | Base | Copy principal, neutra, para qualquer ferramenta. |
| `Session Copy.md` | Base curta | Abertura rápida de sessão (qualquer ferramenta). |
| `Start Session.md` | Operacional | Start padrão do ai-kit para sessões em geral. |
| `Cursor.md` | Ferramenta | Uso específico no Cursor. |
| `Claude.md` | Ferramenta | Uso específico no Claude. |
| `Copilot.md` | Ferramenta | Uso específico no Copilot. |
| `Versao-para-Cursor-Claude-Copilot.md` | Guia | Ajuda a escolher ferramenta por tarefa. |
| `Templates.md` | Modelos | Estruturas prontas de prompt (por tipo de tarefa). |
| `Outros.md` | Diversos | Ideias, variações e rascunhos ainda sem arquivo próprio. |

**Nota (este repo):** `Cursor.md` está na **raiz** do monorepo (`../Cursor.md`), não dentro de `ai-kit/`. Os demais `.md` listados como “no ai-kit” vivem aqui quando existirem.

---

## 2. Prompts base (neutros)

### `Copy.md` — Copy principal base

- **Quando usar**:  
  Quando você quer uma base forte e neutra para iniciar sessão, antes de escolher ferramenta.

- **Serve para**:  
  - definir prioridades (projeto real > dokit > ai-kit);  
  - pedir resumo de estado + plano curto;  
  - alinhar comportamento da IA com o método do kit.

---

### `Session Copy.md` — Copy curta de sessão

- **Quando usar**:  
  No dia a dia, para começar rápido sem colar o prompt completo.

- **Serve para**:  
  - puxar o mínimo necessário de contexto;  
  - garantir foco, escopo e handoff no final.

---

### `Start Session.md` — Start operacional do ai-kit

- **Quando usar**:  
  Quando quer iniciar uma sessão usando explicitamente o ai-kit (não só a copy neutra).

- **Serve para**:  
  - encaixar projeto real + dokit + ai-kit de forma explícita;  
  - ter um “start padrão” independente da ferramenta.

---

## 3. Prompts por ferramenta

### `Cursor.md` — Cursor

- **Quando usar**:  
  Sessões de implementação/refatoração dentro do Cursor.

- **Serve para**:  
  - garantir leitura de contexto antes de editar;  
  - exigir plano curto → mudanças → revisão;  
  - limitar mudanças grandes sem aviso.

---

### `Claude.md` — Claude

- **Quando usar**:  
  Sessões de análise, redesign, diagnóstico, leitura de contexto grande.

- **Serve para**:  
  - pedir resumo de contexto + plano;  
  - tratar docs, arquitetura, decisões;  
  - manter o arquivo `Claude.md` enxuto, jogando detalhes para outros `.md`.

---

### `Copilot.md` — Copilot

- **Quando usar**:  
  Em `.copilot-instructions` e `*.prompt.md` dentro do repo.

- **Serve para**:  
  - explicar a Copilot como o projeto funciona;  
  - definir padrões de sugestão;  
  - alinhar prompts específicos (testes, refatoração, etc.).

---

## 4. Guia de escolha de ferramenta

### `Versao-para-Cursor-Claude-Copilot.md`

- **Quando usar**:  
  Quando estiver em dúvida: “uso Cursor, Claude ou Copilot pra isso aqui?”.

- **Serve para**:  
  - tabela de “melhor ferramenta por tipo de tarefa”;  
  - fluxos combinados (pensar com Claude, executar com Cursor, boilerplate com Copilot).

---

## 5. Modelos e variações

### `Templates.md` — Modelos de prompt

Use para guardar **estruturas prontas** como:

- modelo de prompt para bugfix;
- modelo de prompt para refatoração;
- modelo de prompt para feature nova;
- modelo de prompt para testes;
- modelo de prompt para diagnóstico/handoff.

A ideia é ter “formas” de prompts que você só preenche, em vez de inventar do zero.

---

### `Outros.md` — Rascunhos e casos especiais

Use para:

- variações experimentais;
- prompts muito específicos ainda sem pasta própria;
- ideias que você quer testar mais vezes antes de promover a arquivo próprio.

Regra: se algo de `Outros.md` virar uso recorrente, promove para um arquivo específico ou para `Templates.md`.

---

## 6. Como usar este catálogo

- Está iniciando sessão? → comece em **Base** (Copy / Session / Start Session).  
- Já escolheu ferramenta? → use o `.md` da ferramenta (Cursor / Claude / Copilot).  
- Está em dúvida de ferramenta? → veja **Versao-para-Cursor-Claude-Copilot.md**.  
- Quer criar prompt novo reutilizável? → veja **Templates.md**.  
- Quer estacionar ideias de prompt? → jogue em **Outros.md**.

---

## 7. Gatilhos de atualização

Atualize este arquivo quando:

- adicionar um novo `.md` no ai-kit;
- mudar a função de algum arquivo;
- promover algo de `Outros.md` para arquivo próprio;
- criar novos templates importantes em `Templates.md`.

A função deste arquivo é ser o **mapa mental** do ai-kit: uma leitura rápida e você já sabe onde ir.
