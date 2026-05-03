# Templates.md — Modelos de prompt

Este arquivo guarda **modelos reutilizáveis de prompt** (templates), já alinhados com o método do kit.

Ideia:

- você não precisa lembrar a estrutura toda;
- só copia o template, preenche os blocos `[assim]` e roda.

Os templates aqui são neutros (servem para qualquer ferramenta).  
Quando precisar, combine com os arquivos específicos (`Cursor.md`, `Claude.md`, `Copilot.md`).

**Neste monorepo:** `Cursor.md` está na raiz (`../Cursor.md`).

---

## 1. Template — Bugfix guiado

````md
Contexto do projeto:
- Stack principal: [preencher]
- Parte do sistema: [ex.: backend de auth, UI de tarefas...]

Problema:
- Descreva o bug em 2–3 frases:
[descrever aqui]

Arquivos relevantes:
- [lista de arquivos, se souber]

Quero que você:
1. Leia o contexto e entenda o problema.
2. Me explique em linguagem simples qual é a causa provável.
3. Proponha até 2 caminhos de correção (com trade–offs se fizer sentido).
4. Escolha um caminho e mostre a mudança de código exata.
5. Descreva como testar o bugfix (manual e/ou automatizado).

Regras:
- Não mudar arquitetura ou stack.
- Não abrir refatorações grandes nesta etapa.
- Manter o estilo e padrões já existentes no código.

Objetivo:
[ex.: corrigir o bug sem quebrar fluxo X]
````

---

## 2. Template — Refatoração de módulo

````md
Contexto:
- Módulo/componente: [nome]
- Função atual: [descrição curta]
- Problemas percebidos: [complexidade, acoplamento, duplicação, etc.]

Objetivo da refatoração:
- [ex.: reduzir complexidade, melhorar legibilidade, separar responsabilidades]

Quero que você:
1. Analise o código atual e aponte os principais problemas (com exemplos).
2. Proponha uma nova estrutura (em alto nível) para o módulo.
3. Mostre um plano de refatoração em passos pequenos.
4. Aplique a refatoração passo a passo, explicando cada etapa.
5. Sugira testes ou validações para garantir que nada quebrou.

Regras:
- Não mudar interfaces públicas sem destacar.
- Não trocar stack ou libs sem motivo forte.
- Manter compatibilidade com o uso atual.

Objetivo:
[descrever o que seria “refatorado com sucesso”]
````

---

## 3. Template — Feature nova

````md
Contexto do projeto:
- Tipo de aplicação: [web, API, CLI...]
- Stack: [preencher]
- Domínio da feature: [ex.: cadastro de clientes, exportação de relatório...]

Descrição da feature:
[descrever em 3–5 linhas o que deve existir ao final]

Restrições:
- [ex.: não criar novas tabelas, manter libs atuais, não alterar fluxo X]

Quero que você:
1. Resuma a feature em 2–3 frases para checar entendimento.
2. Proponha uma abordagem de implementação (arquitetura local, entidades, endpoints, UI...).
3. Divida a implementação em passos pequenos e ordenados.
4. Gerar o código aos poucos, por bloco, seguindo os passos.
5. No final, listar o que foi criado/alterado e como testar.

Regras:
- Manter padrões de código existentes.
- Explicar impacto de qualquer mudança em contratos (API, DB).

Objetivo:
[ex.: ter um fluxo mínimo funcional desta feature]
````

---

## 4. Template — Testes (unitários/integrados)

````md
Contexto:
- Linguagem/framework de teste: [preencher]
- Módulo/função alvo: [nome + onde fica]
- Comportamento esperado: [descrição curta]

Quero que você:
1. Resuma em 1–2 frases o que precisa ser testado.
2. Proponha um conjunto de casos de teste (lista).
3. Gerar os testes usando o padrão do projeto (nomes, organização, helpers).
4. Explicar rapidamente o que cada teste cobre.

Regras:
- Não mudar código de produção além do necessário para torná-lo testável (se precisar, destacar).
- Manter estilo e convenções de testes já usados no projeto.

Objetivo:
[ex.: garantir que função X não quebre para casos Y e Z]
````

---

## 5. Template — Diagnóstico / Arquitetura / Decisão

````md
Contexto:
- Projeto: [nome]
- Parte analisada: [ex.: módulo de billing, fluxo de onboarding...]
- Motivo da análise: [problema, dúvida, performance, complexidade...]

Quero que você produza um diagnóstico com esta estrutura:

1. **Resumo executivo**
   - Em até 5 linhas, o que está acontecendo e qual o principal problema.

2. **Situação atual**
   - Como está hoje (arquitetura, fluxo, dependências relevantes).

3. **Problemas principais**
   - Lista dos principais problemas com exemplos e impacto.

4. **Opções de caminho**
   - 2–3 alternativas com benefícios e trade–offs.

5. **Recomendação**
   - Caminho recomendado, por quê e em que condições.

6. **Próximos passos**
   - Passos concretos para aplicar a recomendação.

Regras:
- Baseie–se em código e docs reais, não invente contexto.
- Se informações faltarem, sinalizar o que é suposição.

Objetivo:
[ex.: decidir entre duas abordagens de autenticação]
````

---

## 6. Como usar

- Copie o template da seção correspondente.
- Preencha os campos entre `[ ]` com a realidade do seu caso.
- Se quiser, combine o template com:
  - `Start Session.md` (para start da sessão);
  - `Cursor.md` / `Claude.md` / `Copilot.md` (para adaptar ao ambiente).

---

## 7. Gatilhos de atualização

Atualize este arquivo quando:

- você perceber um tipo de tarefa recorrente que merece um template próprio;
- um template de `Outros.md` virar padrão;
- surgir uma nova categoria de uso (ex.: “integração externa”, “migração de schema”).

A função deste arquivo é te dar **formas prontas** de prompts para não ter que inventar estrutura toda vez.
