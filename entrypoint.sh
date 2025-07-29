#!/bin/bash
set -e

echo "🚀 Starting Laravel Setup..."

# Create required directories
mkdir -p \
    storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache
[ -f ".env" ] && chmod 664 .env

# Create storage link if not exists
if [ ! -L "public/storage" ]; then
    php artisan storage:link
fi

# Optimize application
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

echo "✅ Laravel is ready!"
exec php-fpm -F -R