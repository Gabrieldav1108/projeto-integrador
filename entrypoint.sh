#!/bin/bash
set -e

echo "🚀 Starting Laravel Setup..."

# Verifica se o container do Vite está saudável
if ! curl -s http://vite:5173 >/dev/null; then
    echo "⚠️ Vite container not responding! Assets may not be available."
    echo "ℹ️ Run 'docker-compose up vite' in another terminal if needed"
fi

# Instala dependências do PHP se necessário
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Installing PHP dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Configuração do ambiente
if [ ! -f ".env" ]; then
    echo "⚙️ Initializing environment..."
    cp .env.example .env
    php artisan key:generate --ansi
fi

# Configura permissões
echo "🔧 Setting permissions..."
chmod -R 775 storage bootstrap/cache
[ -f ".env" ] && chmod 664 .env

# Otimiza a aplicação
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan package:discover

echo "✅ Laravel is ready!"
exec php-fpm -F -R