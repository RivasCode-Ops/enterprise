#!/usr/bin/env bash
# Executar UMA VEZ no Ubuntu WSL (22.04), a partir da pasta do projeto ou em qualquer diretório.
# Requer: sudo sem pedido de password OU correr cada sudo manualmente.
set -euo pipefail

echo "==> PHP 8.2 + extensões (PPA ondrej), Composer, Node 20 LTS"

sudo apt-get update
sudo apt-get install -y ca-certificates curl gnupg software-properties-common git unzip

sudo add-apt-repository -y ppa:ondrej/php
sudo apt-get update

sudo DEBIAN_FRONTEND=noninteractive apt-get install -y \
  php8.2-cli php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip \
  php8.2-pgsql php8.2-bcmath php8.2-intl php8.2-redis php8.2-gd

curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
composer --version
php -v

curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt-get install -y nodejs
node -v
npm -v

echo ""
echo "==> Variáveis Sail (WWWUSER / WWWGROUP) — adicionar ao ~/.profile se ainda não existirem"
if ! grep -q 'WWWUSER' ~/.profile 2>/dev/null; then
  {
    echo ''
    echo '# Laravel Sail'
    echo "export WWWUSER=$(id -u)"
    echo "export WWWGROUP=$(id -g)"
  } >> ~/.profile
  echo "Acrescentado a ~/.profile — corre: source ~/.profile"
fi

echo ""
echo "==> Docker Desktop no Windows: ativa integração com esta distro (Settings → Resources → WSL integration)."
echo "==> Projeto (exemplo caminho Windows em D:):"
echo '    cd "/mnt/d/Projetos Dev/enterprise/apps/revenue-share-corretores"'
echo ""
echo "==> Porta 80: se outro contentor Docker já usar :80, para esse contentor ou altera APP_PORT no .env."
echo "==> Subir Sail:"
echo "    ./vendor/bin/sail up -d"
echo "    ./vendor/bin/sail artisan migrate:status"
