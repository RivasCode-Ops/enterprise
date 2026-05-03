# Guia de contribuição

Obrigado pelo interesse em contribuir com este projeto.

Este documento explica como sugerir melhorias, reportar problemas e enviar código de forma organizada.

**Mono-repo:** cada produto em `apps/` pode ter o seu `CONTEXT.md`, `HANDOFF.md` e documentação de segurança. Ao contribuir num app concreto, priorize a documentação **desse** diretório (ex.: `apps/revenue-share-corretores/`).

---

## Antes de começar

1. Leia o [`README.md`](README.md) para entender o objetivo do repositório.
2. Leia o **`CONTEXT.md` do produto** em que vai trabalhar (ex.: [`apps/revenue-share-corretores/CONTEXT.md`](apps/revenue-share-corretores/CONTEXT.md)) para saber:
   - em que fase o projeto está;
   - qual é o foco atual;
   - quais são os próximos passos.
3. Leia o reporte responsável de vulnerabilidades em [`SECURITY.md`](SECURITY.md) (raiz). Para notas técnicas do produto (MVP, CSRF, headers, etc.), veja a doc do app (ex.: [`apps/revenue-share-corretores/docs/security.md`](apps/revenue-share-corretores/docs/security.md)). **Não** divulgue vulnerabilidades em issues públicas antes de contactar os mantenedores.

Se tiver dúvidas gerais, abra uma issue descritiva ou registe no `HANDOFF.md` do produto quando for trabalho interno.

---

## Tipos de contribuição

Você pode contribuir de várias formas:

- Reportando bugs
- Sugerindo melhorias
- Melhorando documentação
- Enviando correções simples
- Propondo novas funcionalidades alinhadas ao contexto

### Reportar bugs

Ao reportar um bug, inclua:

- Descrição clara do problema
- Passos para reproduzir
- Comportamento esperado
- Comportamento atual
- Ambiente (dev/prod, navegador, SO, versão de Node/PHP, etc.)
- Logs relevantes (sem incluir dados sensíveis)

Se você achar que o bug é uma vulnerabilidade de segurança, siga **exclusivamente** [`SECURITY.md`](SECURITY.md) e contacto privado com os mantenedores — não abra issue pública com exploit.

### Sugerir melhorias

Ao sugerir uma melhoria ou nova feature:

- Verifique se não há algo similar já mencionado no `CONTEXT.md` do produto (Future) ou em issues abertas.
- Descreva o problema ou oportunidade que a melhoria resolve.
- Explique, se possível, o impacto para o usuário final ou para a operação.
- Sugira um escopo mínimo viável (o que é essencial e o que pode ficar para depois).

---

## Como enviar mudanças de código

### Passo a passo

1. **Sincronize a branch principal**

   ```bash
   git checkout main
   git pull origin main
   ```

2. **Crie uma branch para sua mudança**

   ```bash
   git checkout -b tipo/mudanca-descritiva
   # Ex.: feature/painel-relatorio, fix/bug-login
   ```

3. **Implemente a mudança**

   - Siga os padrões de código existentes no app tocado.
   - Trabalhe em mudanças pequenas e bem definidas.
   - Evite misturar várias coisas não relacionadas no mesmo commit.

4. **Rode os testes e checks**

   Rode o que estiver documentado no `README.md` do produto ou scripts do app, por exemplo (Laravel):

   ```bash
   cd apps/revenue-share-corretores
   php scripts/verify-mvp-e2e.php
   # ou: composer test / pint, conforme o projeto
   ```

5. **Descreva sua mudança**

   - Nos commits, explique de forma clara o que mudou.
   - No pull request (se for o caso), explique:
     - qual problema foi resolvido;
     - qual abordagem foi usada;
     - se há impactos ou riscos em outras partes.

### Estilo de código

- Siga o padrão predominante nos arquivos mais recentes do mesmo app.
- Evite introduzir novas bibliotecas ou frameworks sem discutir antes.
- Prefira soluções claras e simples a “magias” difíceis de manter.

### Uso de IA (agentes) ao contribuir

Este repositório pode usar agentes de IA com:

- `CONTEXT.md` / `HANDOFF.md` por produto;
- [`Cursor.md`](Cursor.md), [`ai-kit/`](ai-kit/) e regras em `.cursor/` (quando existirem).

Quando usar IA para gerar código ou planos:

- Garanta que o agente leu o `README.md` e o `CONTEXT.md` **do app** relevante.
- Revise o código gerado; não aceite cegamente.
- Documente mudanças relevantes no `HANDOFF.md` do produto ao final da sessão, quando aplicável.

---

## Documentação

Melhorias na documentação são sempre bem-vindas.

- Corrija erros de português, formatação ou clareza.
- Acrescente exemplos de uso, trechos de código ou fluxos importantes.
- Atualize o `CONTEXT.md` do produto quando o estado mudar de forma significativa.

---

## Comportamento

Ao interagir com outras pessoas (issues, PRs, discussões), siga sempre o [Código de Conduta](CODE_OF_CONDUCT.md).

Respeito e clareza são obrigatórios, não opcionais.

---

## Resumo

Para contribuir bem:

1. Entenda o repositório e o produto ([`README.md`](README.md), `CONTEXT.md` do app).
2. Respeite segurança e divulgação responsável de vulnerabilidades.
3. Trabalhe em mudanças pequenas e bem descritas.
4. Use testes e checks do app.
5. Documente o que foi feito (`HANDOFF.md` do produto, quando for o caso).
6. Mantenha um comportamento respeitoso ([`CODE_OF_CONDUCT.md`](CODE_OF_CONDUCT.md)).
