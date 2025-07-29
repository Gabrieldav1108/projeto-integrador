#!/bin/bash
set -e

echo "🚀 Starting Laravel Setup..."

# Verifique e instale dependências se necessário
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installing dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Configure o ambiente
if [ ! -f ".env" ]; then
    echo "⚙️ Initializing environment..."
    cp .env.example .env
    php artisan key:generate --ansi
fi

# Configure permissões
echo "🔧 Setting permissions..."
chmod -R 775 storage bootstrap/cache
[ -f ".env" ] && chmod 664 .env

# Execute os scripts do Laravel
echo "🛠️ Running Laravel optimizations..."
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan package:discover

echo "✅ Laravel is ready!"
exec php-fpm -F -R