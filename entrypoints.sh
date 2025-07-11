#!/bin/bash

# Copiar .env se não existir
if [ ! -f .env ]; then
  cp .env.example .env
fi

# Instalar dependências do composer
composer install

# Gerar chave da aplicação
php artisan key:generate

# Permissões
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Rodar migrations (opcional)
# php artisan migrate --force

npm install
npm run dev &

# Iniciar o servidor PHP
php artisan serve --host=0.0.0.0 --port=8000