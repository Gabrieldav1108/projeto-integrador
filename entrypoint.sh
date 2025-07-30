#!/bin/bash
set -e

echo "🚀 Starting Laravel Setup..."

# Configura permissões compartilhadas
echo "🔧 Setting shared permissions..."
mkdir -p storage/framework/{cache,sessions,views}

# Corrige especificamente o diretório public/hot
if [ -d "public/hot" ]; then
    echo "🛠 Fixing public/hot directory..."
    rm -rf public/hot
fi
touch public/hot
chmod 775 public/hot
chown ${UID:-1000}:${GID:-1000} public/hot

[ -f ".env" ] || cp .env.example .env

# Verifica e instala dependências se necessário (para desenvolvimento)
if [ "$APP_ENV" != "production" ]; then
    if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
        echo "📦 Installing PHP dependencies..."
        composer install --no-interaction --prefer-dist --optimize-autoloader
    fi
fi

# Gera chave de aplicação se necessário
if [ -f ".env" ] && ! grep -q '^APP_KEY=base64' .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --ansi
fi

# Otimiza a aplicação
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan package:discover

echo "✅ Laravel is ready!"
exec php-fpm -F -R