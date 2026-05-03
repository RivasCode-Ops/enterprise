# Uso e utilidade da estrutura do projeto

Este projeto foi organizado para funcionar com padrão profissional de desenvolvimento, documentação, segurança e colaboração entre humano e IA.

A estrutura da raiz `enterprise/` não existe apenas para «guardar arquivos», mas para definir como o projeto deve ser entendido, evoluído e protegido ao longo do tempo.

**Mono-repo:** parte da documentação de estado vive **por produto** em `apps/<nome>/` (`CONTEXT.md`, `HANDOFF.md`, etc.). O que segue descreve o papel de cada tipo de artefacto; aplicável à raiz **e** aos apps, salvo quando um produto define variante própria.

---

## Finalidade da estrutura

A base do projeto é composta por:

- `README.md`
- `CONTEXT.md` (raiz e/ou por app em `apps/`)
- `HANDOFF.md` (raiz e/ou por app)
- política de segurança (`SECURITY.md` na raiz **ou** `docs/security.md` por produto)
- `LICENSE` (quando adoptado)
- `.gitignore`
- workflows de agente (ex.: `.agents/skills/*`, [`ai-kit/`](../ai-kit/), [`.cursor/`](../.cursor/) conforme existirem)

Cada um desses artefactos cumpre uma função específica dentro da engenharia do projeto.

### README.md

O `README.md` é a porta de entrada do projeto.

Ele explica:

- o que o projeto faz;
- qual é a stack (ou onde encontrá-la por app);
- como rodar localmente;
- quais são os padrões operacionais mínimos.

Sua utilidade é reduzir ambiguidade e acelerar onboarding, tanto para humanos quanto para agentes de IA.

### CONTEXT.md

O `CONTEXT.md` registra o estado vivo do projeto.

Ele organiza o projeto em:

- **Past** → origem, histórico, decisões já tomadas;
- **Current** → fase atual, foco atual, tarefas em andamento, riscos;
- **Future** → próximos passos, milestone seguinte, expansão futura.

Sua utilidade é impedir perda de contexto entre sessões e reduzir retrabalho.

### HANDOFF.md

O `HANDOFF.md` registra a transição entre sessões de trabalho.

Modelo reutilizável: [HANDOFF-template.md](HANDOFF-template.md).

Ele serve para documentar:

- o que foi feito;
- o que ficou pendente;
- decisões importantes;
- próximos passos;
- riscos e bloqueios.

Sua utilidade é garantir continuidade operacional sem depender de memória informal.

### Segurança (SECURITY.md ou docs/security.md)

Define como o projeto trata vulnerabilidades e segurança.

Estabelece:

- como reportar falhas;
- o que não deve ser exposto publicamente;
- a postura mínima de segurança do repositório;
- responsabilidades em correção e divulgação.

Sua utilidade é trazer segurança para dentro do ciclo normal de desenvolvimento, em vez de tratá-la como algo opcional.

### LICENSE

O arquivo `LICENSE` define os termos legais de uso, modificação e distribuição do projeto.

Quando usado com MIT, deixa claro que o software pode ser reutilizado com poucas restrições, preservando o aviso de copyright e isenção de garantia.

Sua utilidade é jurídica e operacional: reduz incerteza sobre uso e compartilhamento do código.

### .gitignore

O `.gitignore` protege o repositório contra a inclusão acidental de:

- dependências;
- builds;
- logs;
- arquivos temporários;
- credenciais e variáveis sensíveis;
- artefatos locais de IDE e sistema operacional.

Sua utilidade é preservar higiene do repositório e reduzir risco de vazamento.

### Workflows de agente (.agents/skills, ai-kit, Cursor)

Pastas como `.agents/skills/` (quando existirem) ou o [`ai-kit/`](../ai-kit/) contêm workflows e prompts reutilizáveis.

Padronizam o comportamento do agente para tarefas como:

- iniciar sessão;
- entender contexto;
- implementar feature;
- corrigir bug;
- gerar handoff.

Sua utilidade é transformar conhecimento operacional em processo repetível.

---

## Valor arquitetural

Do ponto de vista de arquitetura de software, esta estrutura melhora o projeto em quatro frentes:

1. **Clareza** — ponto de entrada, estado atual e transição de sessão claramente definidos.
2. **Governança** — regras, segurança, contexto e continuidade deixam de ser informais.
3. **Manutenibilidade** — registro do passado, do presente e do próximo passo.
4. **Escalabilidade operacional** — o projeto pode crescer sem depender exclusivamente da memória do autor.

---

## Valor para engenharia de código

Como engenharia de código, esta estrutura ajuda a:

- evitar mudanças impulsivas sem contexto;
- forçar leitura de documentação antes de editar;
- manter decisões técnicas registradas;
- reduzir refactor desnecessário;
- facilitar debugging e implementação incremental;
- melhorar qualidade de revisão e validação.

Em vez de tratar o código como arquivos soltos, o projeto passa a funcionar como sistema com histórico, direção e critérios de mudança.

---

## Valor para layout e organização do repositório

No sentido de layout do projeto, esta estrutura melhora a navegabilidade e a previsibilidade.

Ela separa claramente:

- documentação do projeto;
- política e segurança;
- contexto de execução;
- workflows do agente;
- código-fonte e módulos do sistema.

Isso reduz ruído e torna o repositório mais legível para qualquer pessoa que entre nele depois.

---

## Valor para segurança

Segurança não deve existir apenas em código defensivo, mas também em processo.

Esta estrutura contribui para segurança porque:

- evita commit acidental de arquivos sensíveis com `.gitignore`;
- cria canal correto de reporte com política de segurança documentada;
- incentiva mudanças pequenas e revisáveis;
- força documentação de contexto e impacto;
- reduz improviso em áreas críticas como autenticação, autorização, dados e integrações.

A segurança do projeto melhora quando arquitetura, desenvolvimento e operação seguem regras explícitas.

---

## Regra operacional do projeto

A regra padrão deste projeto é:

1. Ler `README.md`
2. Ler `CONTEXT.md` (do âmbito em que vai trabalhar — raiz ou `apps/<produto>/`)
3. Ler `HANDOFF.md` quando houver continuidade
4. Escolher o workflow adequado ([`ai-kit/`](../ai-kit/), `.agents/skills`, regras Cursor, etc.)
5. Planejar antes de modificar
6. Executar em passos pequenos
7. Verificar impacto
8. Atualizar contexto e handoff ao final

---

## Fechamento

Esta estrutura deve ser tratada como base oficial do projeto.

Ela existe para:

- dar direção;
- preservar contexto;
- melhorar segurança;
- sustentar boas decisões de arquitetura;
- permitir evolução com menos retrabalho e menos risco.

Qualquer nova funcionalidade, correção, refactor ou melhoria deve respeitar essa base antes de alterar o sistema.
