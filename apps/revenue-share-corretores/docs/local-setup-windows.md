# Ambiente local no Windows

Plano objetivo para rodar **Laravel 11**, **Livewire**, **Tailwind (Vite)**, **PostgreSQL** e **Redis** no desenvolvimento do app `revenue-share-corretores`.

## 1. Caminho recomendado (decisão)

**Docker Desktop com backend WSL2 + desenvolvimento no terminal WSL (Ubuntu), com PostgreSQL e Redis via Laravel Sail.**

### Por quê

- A stack já prevê **PostgreSQL** e **Redis**; subir tudo com **Sail** evita instalar e alinhar extensões PHP no Windows nativo.
- O repositório já tentou usar Docker para `composer create-project`; com o **daemon ativo**, o mesmo fluxo funciona de forma repetível.
- **PHP + Composer só no PATH do Windows** tende a gerar atrito (extensões `pdo_pgsql`, `redis`, diferenças de DLL, múltiplas versões de PHP).

### Alternativa aceitável

**PHP 8.2+ e Composer instalados no WSL (Ubuntu)** — mesmo sem usar Sail para a app, podes usar **apenas containers** para Postgres e Redis (`docker run` ou compose mínimo). Continua a valer ter **Docker Desktop + WSL2** para os serviços de dados.

### O que não é o caminho principal para este projeto

- Depender só de PHP no Windows (PATH) **sem** WSL ou **sem** containers para Postgres/Redis: possível (ex.: Laragon + Postgres instalado), mas **menos alinhado** à stack documentada e mais sujeito a divergência entre máquinas.

---

## 2. Dependências exatas (versões de referência)

| Componente | Versão / nota |
|------------|----------------|
| Windows | 10 ou 11, 64 bits |
| Docker Desktop | Última estável; integração **WSL2** ativada |
| WSL | WSL2 |
| Ubuntu (WSL) | 22.04 LTS ou 24.04 LTS |
| PHP | **8.2.x ou 8.3.x** (Laravel 11 exige **≥ 8.2**) |
| Composer | **2.x** (atual estável) |
| Node.js | **20 LTS** (npm incluído; Vite/Tailwind) |
| PostgreSQL (app) | **15 ou 16** (via Sail, ou instalado no WSL) |
| Redis | **7.x** (via Sail recomendado) |
| Git | Já presente ou última estável |

Extensões PHP necessárias para Laravel + Postgres (nomes típicos no Ubuntu): `mbstring`, `xml`, `curl`, `zip`, `bcmath`, `intl`, `pgsql`, `pdo_pgsql`. Para Redis em PHP (filas/cache nativo): `redis` — opcional no primeiro dia se usares **driver `database`** para filas até Sail estável.

---

## 3. Ordem de instalação

1. **Ativar virtualização** na BIOS (se ainda não estiver), instalar/atualizar **WSL2** (`wsl --install` ou `wsl --update`).
2. Instalar **Docker Desktop**; em definições, confirmar **“Use the WSL 2 based engine”** e integração com a distro Ubuntu.
3. Instalar **Ubuntu** na Microsoft Store (ou distro preferida) e abrir uma vez para concluir o utilizador.
4. No Ubuntu (WSL): `sudo apt update && sudo apt upgrade -y`.
5. Instalar **PHP 8.2+** e extensões listadas acima; instalar **Composer** (instalador oficial); instalar **Node 20** (nvm ou pacotes NodeSource, conforme preferência da equipa).
6. Garantir que o projeto está acessível no WSL (ex.: clone em `~/projetos/enterprise` **ou** trabalhar em `/mnt/d/Projetos Dev/enterprise` — nota: I/O em `/mnt/d` pode ser mais lento; para performance, clone dentro do `~` no WSL).
7. **Antes** de `composer create-project` na pasta do app: **mover temporariamente** para fora (ou zip) os ficheiros que não são Laravel: `README.md`, `CONTEXT.md`, `HANDOFF.md`, pasta `docs/`. Pasta do app **vazia** para o Composer.
8. Na pasta vazia `apps/revenue-share-corretores`:  
   `composer create-project --no-interaction "laravel/laravel:^11.0" .`
9. **Recolocar** `README.md`, `CONTEXT.md`, `HANDOFF.md` e `docs/` na raiz do app (ao lado de `artisan`, `composer.json`, etc.).
10. Adicionar **Laravel Sail** (se ainda não vier no fluxo escolhido): `composer require laravel/sail --dev` e `php artisan sail:install` com **pgsql** e **redis**.
11. Copiar `.env.example` → `.env`; ajustar `DB_*` para o serviço Postgres do Sail; `REDIS_HOST` para o serviço Redis; `APP_URL`.
12. `./vendor/bin/sail up -d` (ou `sail up -d` se alias configurado).
13. `./vendor/bin/sail artisan key:generate` e `./vendor/bin/sail artisan migrate` (quando existirem migrations).

**Livewire + Tailwind:** após o esqueleto Laravel, seguir a documentação oficial Laravel 11 para **Breeze com Livewire** ou stack escolhida pela equipa (`composer require` + `npm install` + `npm run dev` no host ou dentro do container Node conforme setup).

---

## 4. Validação (critério “pronto para Laravel + PostgreSQL”)

- `docker ps` (no Windows ou no WSL) mostra os contentores Sail (ex.: `laravel.test`, `pgsql`, `redis`) **healthy** ou a correr.
- `./vendor/bin/sail artisan --version` responde com Laravel 11.x.
- `./vendor/bin/sail artisan migrate:status` executa **sem** erro de ligação à base (mesmo com zero migrations, confirma **conexão PostgreSQL**).
- `curl -I http://localhost` (ou a porta que o Sail expõe, muitas vezes **80** → `APP_URL`) devolve **200** na página welcome do Laravel.

---

## 5. Fora do âmbito desta sessão

- Modelagem detalhada de colunas e índices (continuar em `docs/database.md` e migrations quando a base Laravel existir).
- Código de domínio (corretores, imóveis, leads).

---

## 6. Situação conhecida desta máquina (referência)

- `php` / `composer` **não** estavam no PATH do PowerShell.
- Cliente **Docker** instalado, mas o **daemon** não estava ativo — é necessário **abrir o Docker Desktop** (ou o serviço equivalente) antes de `docker run` / Sail.

Quando o ambiente acima estiver OK, repetir na pasta do app o fluxo da secção **3** (passos 7–13).

## 7. Notas desta máquina (bootstrap realizado)

- Em disco `D:` (bind mount), `composer install` dentro de `docker run` pode falhar ao apagar pastas em `vendor/composer/`. Mitigação usada: **`docker volume create` + `composer create-project` dentro do volume** + **`docker cp`** para a pasta do projeto.
- O script `./vendor/bin/sail` **recusa** o Git Bash MINGW; usar **`docker compose`** na pasta do app (ex.: `docker compose up -d pgsql redis`).
- O build da imagem **`laravel.test`** pode falhar se o Dockerfile não conseguir alcançar o PPA `ondrej/php`; repetir o build com rede estável ou desenvolver a partir de **WSL Ubuntu** com Sail, como previsto no plano principal.

---

## 8. Ubuntu 22.04 WSL2 + Sail nativo (Fase 1 — caminho oficial)

### Instalar a distro

No PowerShell **como administrador** (se necessário):

```powershell
wsl --install -d Ubuntu-22.04
wsl --set-default Ubuntu-22.04
```

Na primeira vez, abre **Ubuntu** no menu Iniciar e conclui a criação do utilizador UNIX (nome + password). Sem este passo, comandos `wsl` invocados por ferramentas automatizadas podem não terminar.

### Docker Desktop ↔ WSL

Em **Docker Desktop → Settings → Resources → WSL integration**: ativa a integração para **Ubuntu-22.04**.

### Ferramentas no Ubuntu (PHP, Composer, Node 20)

No terminal Ubuntu:

```bash
cd "/mnt/d/Projetos Dev/enterprise/apps/revenue-share-corretores"
chmod +x scripts/wsl-ubuntu-sail-bootstrap.sh
./scripts/wsl-ubuntu-sail-bootstrap.sh
source ~/.profile
```

(Isto usa o PPA `ondrej/php` — necessário para PHP 8.2 no Ubuntu 22.04.)

### Porta 80 e `.env`

O projeto está configurado para **Sail padrão** (`APP_PORT=80`, `APP_URL=http://localhost`). Se **outro contentor** já publicar `0.0.0.0:80`, ou paras esse stack ou defines outra porta (ex.: `APP_PORT=8080`) e ajustas `APP_URL`.

### Substituir o contorno `php artisan serve`

- Contentor auxiliar `revenue-share-corretores-app` (**9888**) deve estar parado/removido.
- Serviços de dados existentes: `docker compose up -d pgsql redis` (já usados pelo projeto) ou deixa o Sail subir tudo com `./vendor/bin/sail up -d`.

### Validar Sail nativo (no Ubuntu)

```bash
cd "/mnt/d/Projetos Dev/enterprise/apps/revenue-share-corretores"
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:status
./vendor/bin/sail artisan migrate
curl -s -o /dev/null -w "%{http_code}" http://localhost/
```

Esperado: `migrate` sem erros; `curl` **200** em `http://localhost/` (porta 80 no Windows, mapeada pelo Sail).

### Por que não confiar só no build `docker compose build laravel.test` no Windows

O `Dockerfile` do Sail compila uma imagem grande e depende de vários mirrors (PPA ondrej, NodeSource, etc.). Falhas de rede nesse build **não** impedem o Sail quando corres `./vendor/bin/sail` a partir do **WSL Ubuntu**, porque o script Sail orquestra `docker compose` com o contexto certo e evitas o Git Bash MINGW (que o Laravel Sail bloqueia).

---

## 9. Validação final Fase 1 (no terminal Ubuntu) + fallbacks

Executar **na ordem** após `§8` (bootstrap, `source ~/.profile`, integração Docker).

### A) Caminho completo (Sail padrão, HTTP na 80)

```bash
cd "/mnt/d/Projetos Dev/enterprise/apps/revenue-share-corretores"
docker ps --format '{{.Names}} {{.Ports}}' | grep ':80->'   # se houver conflito, parar o outro contentor ou mudar APP_PORT
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:status
./vendor/bin/sail artisan migrate
curl -I http://localhost
```

**Marco roadmap Fase 1:** `sail artisan migrate` (equivalente a `php artisan migrate` dentro do contentor `laravel.test`) sem erros; `curl` com **HTTP/200** (ou 302 para login) em `http://localhost:80`.

> **só `pgsql` + `redis`:** se quiseres levantar primeiro os dados e só depois o PHP: `./vendor/bin/sail up -d pgsql redis` — útil enquanto a imagem `laravel.test` estiver a construir.

### B) Se `./vendor/bin/sail up -d` falhar ao **buildar** `laravel.test` (rede / PPA)

1. Subir **apenas** dados: na pasta do app (PowerShell ou Ubuntu):

   ```bash
   docker compose up -d pgsql redis
   ```

2. Correr migrations com PHP **fora** do Sail, na rede do projeto (exemplo já testado neste repo):

   ```bash
   docker run --rm --network revenue-share-corretores_sail --env-file .env \
     -v "$(pwd)":/var/www/html -w /var/www/html php:8.2-cli \
     bash -c "apt-get update -qq && apt-get install -y -qq libpq-dev >/dev/null && docker-php-ext-install -j4 pdo_pgsql >/dev/null 2>&1 && php artisan migrate --force"
   ```

3. Para HTTP sem `laravel.test`, é preciso outro servidor (não é o alvo final); repete **A)** quando o build Sail funcionar ou trabalha a partir de uma máquina com rede estável ao PPA.

### C) Automação (Cursor / CI)

Comandos `wsl -d Ubuntu-22.04 …` invocados a partir do Windows **podem não terminar** até o Ubuntu ter utilizador criado no primeiro arranque. A validação **A)** deve ser feita **localmente** no app Ubuntu.

---

## 10. Diagnóstico: build `laravel.test` / PPA `ondrej/php` (rede)

O `Dockerfile` do Sail instala PHP a partir do **PPA Launchpad** (`ppa.launchpadcontent.net`), não do repositório **packages.sury.org** (Debian). Um mirror pode estar acessível e o outro não.

### 10.1 Testes rápidos de conectividade (registo neste ambiente)

Execute no host ou dentro de um contentor (`docker run --rm alpine` + `apk add curl`):

| Alvo | Comando de exemplo | Resultado esperado | Resultado observado (diagnóstico) |
|------|-------------------|----------------------|-----------------------------------|
| Sury (referência HTTPS) | `curl -sI https://packages.sury.org/php/apt.gpg` | cabeçalhos **HTTP 200** | **200** — HTTPS externo ok |
| PPA ondrej (bloqueador típico do build Sail) | `curl -sI --max-time 60 https://ppa.launchpadcontent.net/ondrej/php/ubuntu/dists/noble/InRelease` | **HTTP 200** ou redirecionamento válido | **Falha**: no Windows (`curl.exe`) timeout (exit 28); no Alpine sem `--dns` extra, `curl` exit **7**; com DNS 8.8.8.8 ainda **connection refused** em `185.125.190.80:443` |

Se **Sury responde** mas **Launchpad não**, o problema **não** é “internet genérica”: é **acesso ao domínio/IP do Launchpad** (firewall, ISP, VPN corporativa, geo ou política de rede).

### 10.2 Falha típica no `docker compose build laravel.test`

Após `docker compose build laravel.test --no-cache`, o log pode mostrar:

- `Could not connect to ppa.launchpadcontent.net:443 (185.125.190.80). - connect (111: Connection refused)`
- Depois: `Unable to locate package php8.5-cli` (e restantes pacotes `php8.5-*`), porque o índice do PPA não foi obtido.
- Exit do passo `RUN apt-get ...`: **100**.

Isto confirma que o build depende de **HTTPS ao Launchpad**, não só de `archive.ubuntu.com`.

### 10.3 DNS no Compose vs DNS no *build*

- O ficheiro `compose.yaml` inclui `dns: [8.8.8.8, 8.8.4.4]` no serviço **`laravel.test`** para **contentores em execução** (runtime).
- **`docker compose build`** usa a rede do **daemon Docker**; o bloco `dns:` do serviço **não** aplica ao passo de build. Para influenciar resolução durante o build:
  - **Docker Desktop** → **Settings** → **Docker Engine**: acrescentar, por exemplo, `"dns": ["8.8.8.8", "8.8.4.4"]` ao JSON (Apply & Restart).
  - Em Linux/WSL puro: `/etc/docker/daemon.json` equivalente.

Se, mesmo assim, `curl` ao Launchpad continuar com **timeout** ou **connection refused**, trata-se de **bloqueio de rota/firewall**, não de DNS: mudar apenas DNS não desbloqueia o build.

### 10.4 Quando o build continua impossível nesta rede

Seguir **§9-B** (subir `pgsql` + `redis`, migrations com `php:8.2-cli` na rede do projeto). É o caminho suportado até haver rede que alcance o Launchpad ou até construir a imagem noutra máquina/CI e publicar no registry.

### 10.5 Comandos de limpeza + rebuild (checklist)

```bash
cd apps/revenue-share-corretores
docker builder prune --all -f
docker compose build laravel.test --no-cache
```

Se o build concluir com sucesso: `./vendor/bin/sail up -d` e `./vendor/bin/sail artisan migrate` (ou equivalente via `docker compose`).
