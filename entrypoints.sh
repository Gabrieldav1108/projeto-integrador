#!/bin/bash

# Instala as dependências PHP se não houver vendor
if [ ! -f vendor/autoload.php ]; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Copia .env se necessário
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Garante que a APP_KEY está definida
if ! grep -q '^APP_KEY=' .env || grep -q '^APP_KEY=$' .env; then
  php artisan key:generate --ansi
fi

# Corrige permissões
find storage -type d -exec chmod 775 {} \;
find storage -type f -exec chmod 664 {} \;
find bootstrap/cache -type d -exec chmod 775 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;

# Garante que www-data seja o dono
chown -R www-data:www-data storage bootstrap/cache

# Garante que novos arquivos herdem as permissões do grupo
chmod g+s storage bootstrap/cache

# Limpa cache de configuração se existir
if [ -f bootstrap/cache/config.php ]; then
  php artisan config:clear
fi

echo "✅ Laravel pronto. Iniciando PHP-FPM..."
exec php-fpm