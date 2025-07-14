#!/bin/sh
set -e

# Configurações básicas
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
fi

# Permissões
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Iniciar PHP-FPM
exec php-fpm