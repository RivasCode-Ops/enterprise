# Cursor.md — Prompt específico para Cursor

Este arquivo contém a versão adaptada da copy base do `ai-kit` para uso no **Cursor**.

Objetivo:

- fazer o Cursor usar corretamente o contexto real do projeto;
- aplicar o método universal do `dokit`;
- aproveitar o fluxo de edição incremental do Cursor (plano → mudanças → revisão).

---

## 1. Copy para iniciar sessão no Cursor

````md
Você está atuando no Cursor neste projeto.

Prioridade de contexto:

1. arquivos reais do projeto (especialmente README, CONTEXT, HANDOFF e qualquer doc vivo na raiz);
2. o `dokit` como método universal (AGENTS, CONTEXT, DECISIONS, FLUXO, HANDOFF, START-SESSION);
3. o `ai-kit` como biblioteca de prompts operacionais.

Antes de editar qualquer arquivo:

1. identifique a estrutura do projeto (pastas, arquivos principais);
2. leia a documentação viva do projeto;
3. leia o `dokit` apenas como método, não como status real;
4. use o `ai-kit` apenas como apoio de prompt.

Quero que você:

- confirme o estado atual do projeto em poucas frases;
- resuma a tarefa da sessão;
- proponha um plano curto de passos dentro do Cursor;
- só então comece a sugerir mudanças de código.

Regras específicas para esta sessão no Cursor:

- peça confirmação antes de alterações grandes na estrutura ou arquitetura;
- não mude stack, fluxo principal ou contratos críticos sem sinalizar;
- não abra novas frentes fora do escopo atual;
- mantenha as mudanças focadas e bem localizadas;
- explique o impacto de alterações sensíveis (banco, autenticação, integrações, domínio).

Ao sugerir código:

- indique claramente quais arquivos serão alterados;
- evite mudanças em cascata sem necessidade;
- prefira pequenas iterações que possam ser revisadas rapidamente.

Ao final da sessão:

- resuma o que foi feito em 3–7 linhas;
- liste pendências imediatas;
- liste riscos ou dúvidas que precisam de decisão;
- indique quais documentos devem ser atualizados (CONTEXT, HANDOFF, DECISIONS, etc.).

Objetivo desta sessão no Cursor:
[descreva aqui]
````

---

## 2. Versão curta para Cursor (uso diário)

````md
Atue no Cursor com esta prioridade:

1. contexto real do projeto;
2. método do `dokit`;
3. prompts do `ai-kit` como apoio.

Antes de editar:
- leia README/CONTEXT/HANDOFF reais;
- resuma estado atual;
- resuma tarefa;
- proponha plano curto.

Durante:
- mantenha foco no escopo;
- não mude arquitetura/stack sem sinalizar;
- faça mudanças pequenas e claras;
- explique impacto de alterações sensíveis.

Ao final:
- resuma entregas, pendências, riscos e próximos passos;
- indique quais docs atualizar.

Objetivo:
[descreva aqui]
````

---

## 3. Fluxo recomendado dentro do Cursor

Use este fluxo quando estiver trabalhando em sessões um pouco mais longas:

1. **Exploração rápida**  
   - abrir a estrutura de arquivos;
   - ler a documentação viva relevante;
   - identificar onde a mudança provavelmente vai acontecer.

2. **Alinhamento de objetivo**  
   - colar a copy principal ou curta deste `Cursor.md`;
   - deixar explícito o objetivo da sessão;
   - pedir ao Cursor um resumo do estado + plano.

3. **Execução incremental**  
   - aplicar as mudanças em blocos pequenos;
   - revisar diff a cada passo;
   - testar localmente quando fizer sentido.

4. **Revisão e limpeza**  
   - revisar arquivos tocados;
   - evitar código morto ou experimental sem motivo;
   - alinhar nomes e padrões ao existente.

5. **Encerramento e handoff**  
   - registrar resumo, pendências e próximos passos;
   - apontar para atualização de CONTEXT/HANDOFF/DECISIONS no projeto real.

---

## 4. Como este arquivo se relaciona com outros

- Base conceitual → `ai-kit/Copy.md`
- Versão curta → `ai-kit/Session Copy.md`
- Versão universal de start session → `dokit/START-SESSION.md`

Use este `Cursor.md` quando:

- estiver trabalhando diretamente dentro do Cursor;
- quiser que o agente siga o fluxo e as prioridades certas;
- não quiser reescrever explanações todas as vezes.

---

## 5. Gatilhos de atualização

Atualize este arquivo quando:

- o fluxo de uso do Cursor mudar;
- o projeto ganhar uma prática melhor de sessão no editor;
- o relacionamento entre projeto real, `dokit` e `ai-kit` for alterado;
- a copy base (`Copy.md`) mudar de forma significativa.

A função deste arquivo é tornar o uso do Cursor consistente com o método do projeto, sem reinventar o fluxo em cada sessão.
