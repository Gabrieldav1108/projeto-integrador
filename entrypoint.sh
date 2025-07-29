#!/bin/bash
set -e

echo "🚀 Starting Laravel Auto-Setup..."

# 1. Load environment variables
export COMPOSER_ALLOW_SUPERUSER=1

# 2. Create required directory structure first
echo "📂 Ensuring directory structure..."
mkdir -p \
    storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache

# 3. Automatic permission synchronization
echo "🔧 Synchronizing permissions..."
HOST_UID=${HOST_UID:-1000}
HOST_GID=${HOST_GID:-1000}

# Apply safe permissions (only to Laravel-required directories)
for dir in storage bootstrap/cache; do
    if [ -d "/var/www/$dir" ]; then
        chown -R $HOST_UID:$HOST_GID "/var/www/$dir" || true
        chmod -R 775 "/var/www/$dir" || true
    fi
done

# Special handling for .env
[ -f "/var/www/.env" ] && chmod 664 "/var/www/.env" || true

# 4. Dependency installation with retry logic
install_dependencies() {
    local max_retries=3
    local attempt=0
    local delay=10
    
    while [ $attempt -lt $max_retries ]; do
        ((attempt++))
        echo "📦 Installing dependencies (attempt $attempt/$max_retries)..."
        
        if composer install --no-interaction --prefer-dist --optimize-autoloader; then
            return 0
        fi
        
        echo "⚠️ Attempt $attempt failed, retrying in $delay seconds..."
        sleep $delay
    done
    
    return 1
}

if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    install_dependencies || {
        echo "❌ Failed to install dependencies after maximum attempts"
        exit 1
    }
fi

# 5. Environment configuration
if [ ! -f ".env" ]; then
    echo "⚙️ Initializing environment..."
    cp .env.example .env
    php artisan key:generate --ansi
fi

# 6. Application optimization
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan storage:link

# 7. Final permission check
echo "🔍 Verifying permissions..."
[ -w storage ] || chmod 775 storage
[ -w bootstrap/cache ] || chmod 775 bootstrap/cache

# 8. Health check before starting
if [ -f "vendor/autoload.php" ] && [ -w storage ] && [ -w bootstrap/cache ]; then
    echo "✅ System ready! Starting PHP-FPM..."
    exec php-fpm -F -R
else
    echo "❌ Critical: System not ready for startup"
    exit 1
fi