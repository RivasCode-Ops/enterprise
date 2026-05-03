# Copy.md — Copy principal base

Este arquivo contém a **copy principal base** do `ai-kit`.

Ele deve ser usado como prompt mestre neutro para iniciar sessões com agentes de IA em tarefas de desenvolvimento, análise e continuidade de projeto.

Esta copy:

- não depende de uma ferramenta específica;
- não substitui o contexto real do projeto;
- não substitui o `dokit`;
- serve como base para criar ou adaptar versões específicas para Cursor, Claude, Copilot e outros agentes.

---

## 1. Objetivo

Use esta copy quando quiser:

- iniciar uma sessão nova com clareza;
- orientar a IA a ler o contexto certo;
- manter foco, escopo e continuidade;
- evitar que a IA confunda projeto real com templates ou prompts auxiliares;
- gerar uma base consistente para outras variações do `ai-kit`.

---

## 2. Copy principal

````md
Atue neste projeto com foco em clareza, continuidade e respeito ao escopo atual.

Antes de qualquer implementação ou recomendação:

1. identifique quais arquivos representam o contexto real do projeto;
2. leia primeiro a documentação viva do projeto;
3. use o kit universal (`dokit`) como método de trabalho;
4. use o `ai-kit` apenas como biblioteca de prompts operacionais.

Quero que você siga esta ordem de prioridade:

1. documentação real do projeto;
2. `dokit` como método universal;
3. `ai-kit` como apoio operacional por ferramenta ou cenário.

Antes de agir:
- confirme o estado atual do projeto;
- resuma a tarefa pedida;
- proponha um plano curto de execução;
- identifique dúvidas, riscos ou ambiguidades relevantes.

Durante a execução:
- mantenha foco no escopo atual;
- não abra novas frentes sem necessidade real;
- não mude stack, arquitetura ou fluxo principal sem sinalizar;
- não trate templates como se fossem o estado vivo do projeto;
- preserve padrões já existentes.

Ao finalizar:
- resuma o que foi feito;
- aponte o que ficou pendente;
- registre riscos ou pontos de atenção;
- indique próximos passos;
- atualize os documentos corretos de continuidade quando aplicável.

Se houver conflito entre documentos:
1. priorize o contexto real do projeto;
2. depois as regras do `dokit`;
3. por último, use este `ai-kit` apenas como suporte operacional.

Objetivo da sessão:
[descreva aqui]
````
