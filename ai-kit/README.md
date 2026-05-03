# ai-kit — Biblioteca de prompts e copies operacionais

Este diretório reúne prompts, copies e variações operacionais para uso com ferramentas de IA como Cursor, Claude, Copilot e outros agentes.

O objetivo do `ai-kit` é:

- acelerar o início de sessões;
- adaptar instruções ao comportamento de ferramentas diferentes;
- manter prompts reutilizáveis e organizados;
- reduzir improviso e repetição no uso diário.

Este diretório **não substitui** o contexto real do projeto nem o `dokit`.

Pense assim:

- projeto real = realidade atual;
- `dokit` = método universal;
- `ai-kit` = biblioteca de prompts operacionais por ferramenta e cenário.

---

## Papel do `ai-kit`

Use o `ai-kit` para organizar:

- copy principal;
- versões curtas de sessão;
- prompts específicos por ferramenta;
- comparativos entre ferramentas;
- modelos reutilizáveis;
- variações experimentais ou complementares.

O `ai-kit` existe para facilitar execução.  
Ele não deve virar a fonte oficial de estado do projeto.

---

## Ordem de uso recomendada

Antes de usar qualquer prompt do `ai-kit`:

1. entender o contexto real do projeto;
2. identificar se existe `README.md`, `CONTEXT.md`, `HANDOFF.md` ou outros documentos vivos na raiz do projeto;
3. consultar o `dokit` para regras universais;
4. só então escolher a variação mais adequada dentro do `ai-kit`.

Regra simples:

- primeiro entender o projeto;
- depois escolher a ferramenta;
- só então escolher a copy.

---

## Arquivos do `ai-kit`

### `Copy.md`

Copy principal base.

Use como prompt mestre neutro, sem dependência de ferramenta específica.  
Serve como origem para adaptar outras versões.

---

### `Session Copy.md`

Copy curta de sessão.

Use quando quiser uma abertura rápida, com menos contexto e mais objetividade.  
Boa para uso diário, sessões curtas ou tarefas pequenas.

---

### `Start Session.md`

Abertura operacional do `ai-kit`.

Use quando quiser iniciar uma sessão com mais estrutura, mas ainda em nível de prompt operacional e não de kit universal.

---

### `Cursor.md`

Versão adaptada para Cursor.

Use quando a sessão acontecer no Cursor e você quiser:

- leitura de contexto;
- plano curto antes de execução;
- comportamento mais orientado a edição e fluxo contínuo.

**Neste monorepo:** o ficheiro está na **raiz** do repositório (`../Cursor.md`), não dentro de `ai-kit/`.

---

### `Claude.md`

Versão adaptada para Claude.

Use quando quiser:

- retomada forte de contexto;
- leitura mais cuidadosa de handoff e documentos;
- raciocínio mais guiado por contexto escrito.

---

### `Copilot.md`

Versão adaptada para Copilot.

Use quando a sessão depender mais de instruções persistentes, prompts reutilizáveis e contexto enxuto voltado a edição assistida.

---

### `Versao-para-Cursor-Claude-Copilot.md`

Comparativo entre ferramentas.

Use para entender:

- o que muda entre uma ferramenta e outra;
- por que a mesma copy não performa igual em todas;
- qual adaptação escolher em cada caso.

---

### `Prompts.md`

Catálogo geral dos prompts disponíveis.

Use para:

- consultar rapidamente as opções;
- visualizar o conjunto de prompts existentes;
- manter um inventário consolidado.

Se este arquivo começar a repetir o `README.md`, simplificar sua função para catálogo puro.

---

### `Templates.md`

Modelos reutilizáveis.

Use para guardar estruturas-base, por exemplo:

- template de bugfix;
- template de refatoração;
- template de retomada;
- template de implementação nova.

---

### `Outros.md`

Prompts e variações não classificadas.

Use para:

- experimentos;
- casos especiais;
- versões ainda não consolidadas;
- materiais que não merecem arquivo próprio ainda.

Evite deixar este arquivo crescer demais.  
Se um item ficar recorrente, promover para arquivo próprio.

---

## Como escolher o arquivo certo

Use esta lógica:

- precisa de uma base neutra? → `Copy.md`
- precisa de uma abertura curta? → `Session Copy.md`
- precisa de uma abertura mais guiada? → `Start Session.md`
- vai usar Cursor? → `Cursor.md`
- vai usar Claude? → `Claude.md`
- vai usar Copilot? → `Copilot.md`
- quer comparar comportamentos entre ferramentas? → `Versao-para-Cursor-Claude-Copilot.md`
- quer um modelo para reaproveitar? → `Templates.md`
- quer ver tudo que existe? → `Prompts.md`
- quer consultar sobras, testes ou variações? → `Outros.md`

---

## Relação com o `dokit`

O `dokit` define o método universal:

- regras;
- contexto;
- decisões;
- fluxo;
- handoff;
- start session universal.

O `ai-kit` adapta esse método ao uso operacional com ferramentas específicas.

Regra prática:

- quer saber **como o projeto deve ser conduzido**? → vá para o `dokit`
- quer saber **qual prompt usar em cada ferramenta**? → vá para o `ai-kit`

---

## O que o `ai-kit` não deve fazer

Este diretório não deve virar:

- documentação oficial do estado atual do projeto;
- substituto do `CONTEXT.md`;
- substituto do `HANDOFF.md`;
- substituto do `README.md` da raiz;
- depósito caótico de prompts sem função definida.

Se um prompt depender de contexto real, ele deve apontar para os documentos corretos do projeto.

---

## Gatilhos de atualização

Atualize este README quando:

- um novo arquivo for adicionado ao `ai-kit`;
- a função de um arquivo mudar;
- houver duplicidade entre prompts;
- uma ferramenta nova entrar no fluxo;
- a ordem ideal de escolha de prompts mudar.

---

## Controle do ai-kit (monorepo `enterprise`)

| Arquivo | Papel | Status | Observação |
|---------|-------|--------|------------|
| `README.md` | Índice do ai-kit e guia de uso | Feito | Este ficheiro |
| `Copy.md` | Copy principal base | Feito | Versão inicial no repo |
| `Prompts.md` | Catálogo geral de prompts | Feito | Ver nota `Cursor.md` na §1 |
| `Outros.md` | Casos especiais e variações | Feito | Template de rascunhos |
| `Session Copy.md` | Copy curta para sessão | Feito | Três variantes: geral, enxuta, retomada |
| `Start Session.md` | Abertura operacional do ai-kit | Feito | Geral, curta e retomada |
| `Cursor.md` | Prompt específico para Cursor | Feito | Na **raiz** do repo: `../Cursor.md` |
| `Claude.md` | Prompt específico para Claude | Pendente | |
| `Copilot.md` | Prompt específico para Copilot | Pendente | |
| `Versao-para-Cursor-Claude-Copilot.md` | Comparativo entre ferramentas | Feito | Tabela + fluxos combinados |
| `Templates.md` | Modelos reutilizáveis | Feito | Bugfix, refatoração, feature, testes, diagnóstico |

---

## Princípio do diretório

O `ai-kit` existe para reduzir atrito entre intenção e execução.

Ele deve tornar mais fácil:

- escolher o prompt certo;
- usar a ferramenta certa;
- começar com clareza;
- repetir o que funciona.
