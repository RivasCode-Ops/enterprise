# Versao-para-Cursor-Claude-Copilot.md — Guia de escolha

Este arquivo ajuda a escolher **rapidamente** entre Cursor, Claude e Copilot para cada tipo de tarefa, usando o mesmo kit (dokit + ai-kit) por baixo.

**Neste monorepo:** `Cursor.md` está na **raiz** do repositório (`../Cursor.md`); os demais `.md` do kit citados abaixo vivem em `ai-kit/` quando existirem.

Pense assim:

- **Cursor** → fluxo contínuo de edição de código.
- **Claude** → raciocínio profundo, contexto grande, análise e redesign.
- **Copilot** → autocomplete e snippets rápidos, bem integrado com editor/IDE.

---

## 1. Quando usar cada ferramenta

### Cursor — melhor para

- Implementar **features novas** em código já existente.
- Fazer **refatorações guiadas** com feedback rápido de diff.
- Ajustar múltiplos arquivos de forma incremental.
- Sessões longas de “pair programming” com foco em navegação e edição.

Use junto com:

- `../Cursor.md` (raiz do repo) ou referência “Cursor.md” do kit
- `ai-kit/Session Copy.md`
- `dokit/FLUXO.md` e `dokit/HANDOFF.md`

---

### Claude — melhor para

- Entender ou redesenhar **arquitetura** e **fluxos complexos**.
- Fazer resumo de contexto grande (muitos arquivos ou docs).
- Explorar alternativas de design, trade–offs, decisões técnicas.
- Escrever/ajustar documentação mais longa (diagnósticos, propostas, etc.).

Use junto com:

- `ai-kit/Claude.md`
- `ai-kit/Copy.md` ou `ai-kit/Start Session.md`
- `dokit/CONTEXT.md` e `dokit/DECISIONS.md`

---

### Copilot — melhor para

- **Autocomplete** de código, testes e pequenos blocos repetitivos.
- Criar rapidamente esqueletos de funções, componentes, testes.
- Ajudar em pequenas correções pontuais, em linha.
- Suporte contínuo no editor, sem precisar de prompt longo.

Use junto com:

- `ai-kit/Copilot.md` (como base para `.copilot-instructions` e `*.prompt.md`)
- `ai-kit/Templates.md` para prompts específicos (ex.: “gerar testes para X”).

---

## 2. Tabela rápida de escolha

| Tarefa | Ferramenta preferida | Observação |
|-------|----------------------|-----------|
| Feature nova média/grande | Cursor | Fluxo incremental, diffs claros. |
| Refatorar módulo inteiro | Cursor + Claude | Cursor executa, Claude ajuda a pensar. |
| Entender projeto grande | Claude | Boa em resumir e reorganizar contexto. |
| Decisão de arquitetura | Claude | Usa CONTEXT + DECISIONS melhor. |
| Bug pequeno/local | Copilot | Autocomplete direto no editor. |
| Gerar testes unitários | Copilot (com prompts) | Rápido para boilerplate. |
| Ajustar vários arquivos com plano | Cursor | Plano → diffs → validação. |
| Escrever docs/diagnóstico | Claude | Melhor para texto longo e estruturado. |

---

## 3. Como combinar as três

### Fluxo 1 — Pensar com Claude, executar com Cursor

1. Usar **Claude** para:
   - ler CONTEXT/HANDOFF;
   - entender o problema;
   - propor arquitetura/ajustes e um plano.

2. Levar o plano para o **Cursor**:
   - usar `../Cursor.md` + fluxo do kit;
   - aplicar o plano em passos pequenos;
   - revisar diffs e testar.

3. Documentar:
   - voltar em Claude (ou no próprio repo) para atualizar CONTEXT/HANDOFF/DECISIONS.

---

### Fluxo 2 — Esqueleto com Copilot, refinamento com Cursor/Claude

1. Usar **Copilot** para:
   - gerar o esqueleto de funções, componentes ou testes;
   - acelerar partes repetitivas.

2. Usar **Cursor** para:
   - integrar esse código no fluxo real;
   - refinar, limpar e alinhar ao padrão do projeto.

3. Usar **Claude** se precisar:
   - revisar arquitetura;
   - checar impactos maiores.

---

## 4. Regras gerais por ferramenta

### Cursor

- Sempre começar com: `ai-kit/Start Session.md` + `../Cursor.md`.
- Pedir plano curto antes de grandes mudanças.
- Prefira mudanças em blocos pequenos + revisão de diff.
- Evitar “reescrever o projeto inteiro” numa tacada só.

### Claude

- Começar sessões importantes com: `ai-kit/Claude.md` + `ai-kit/Start Session.md`.
- Dar documentos e contexto primeiro, pedir **resumo + plano** depois.
- Usar para:
  - explicar;
  - propor alternativas;
  - estruturar decisões.

### Copilot

- Configurar `.copilot-instructions` tendo este kit em mente (`ai-kit/Copilot.md`).
- Deixar prompts específicos em `*.prompt.md` (Templates/Prompts).
- Usar para:
  - autocomplete;
  - pequenos blocos;
  - testes;
  - repetição.

---

## 5. Como este arquivo se encaixa no ai-kit

- `Copy.md` → filosofia base.
- `Session Copy.md` → abertura curta.
- `Start Session.md` → abertura operacional padrão.
- `Cursor.md` → uso fino no Cursor (neste repo: `../Cursor.md`).
- `Claude.md` → uso fino no Claude.
- `Copilot.md` → uso fino no Copilot.
- `Versao-para-Cursor-Claude-Copilot.md` → **este arquivo**, pra escolher quem entra em campo primeiro.

---

## 6. Quando atualizar este arquivo

Atualize quando:

- você mudar seu “meta–jogo” (ex.: passar a usar mais Claude para gerar código e menos Cursor);
- entrar ferramenta nova ou sair alguma;
- perceber que um tipo de tarefa mudou de “casa” (ex.: passou a ser melhor no Claude do que no Cursor).

A função deste arquivo é simples:

> olhar pra tarefa, bater o olho aqui e saber **com quem você vai jogar essa bola primeiro**.
