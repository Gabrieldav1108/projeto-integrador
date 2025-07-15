#!/bin/sh
set -e

# Instala as dependências PHP se não houver vendor
if [ ! -f vendor/autoload.php ]; then
  echo "Instalando dependências do PHP..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Configurações básicas
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
fi

# Garante que a APP_KEY está definida
if ! grep -q "^APP_KEY=" .env || grep -q "^APP_KEY=$" .env; then
  php artisan key:generate --ansi
fi

# Permissões
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Iniciar PHP-FPM
exec php-fpm