#!/bin/sh
set -e

echo "🚀 Inicializando Laravel..."

# Instala as dependências PHP se não houver vendor
if [ ! -f vendor/autoload.php ]; then
  echo "📦 Instalando dependências PHP com Composer..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Copia .env se necessário
if [ ! -f .env ]; then
  echo "⚙️ Criando .env a partir do .env.example"
  cp .env.example .env
fi

# Garante que a APP_KEY está definida
if ! grep -q '^APP_KEY=' .env || grep -q '^APP_KEY=$' .env; then
  echo "🔑 Gerando nova APP_KEY..."
  php artisan key:generate --ansi
fi

# Corrige permissões
echo "🔧 Corrigindo permissões das pastas storage e bootstrap/cache..."
find storage -type d -exec chmod 775 {} \;
find storage -type f -exec chmod 664 {} \;
find bootstrap/cache -type d -exec chmod 775 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;

# Limpa cache de configuração se existir
if [ -f bootstrap/cache/config.php ]; then
  php artisan config:clear
fi

echo "✅ Laravel pronto. Iniciando PHP-FPM..."
exec php-fpm