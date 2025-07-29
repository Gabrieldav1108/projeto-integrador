#!/bin/bash
set -e

echo "🚀 Starting Laravel Auto-Setup..."

# Run permission fix
fix-permissions

# 1. Create required directory structure
echo "📂 Ensuring directory structure..."
mkdir -p \
    storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache

# 2. Dependency installation with retry logic
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

# 3. Environment configuration
if [ ! -f ".env" ]; then
    echo "⚙️ Initializing environment..."
    cp .env.example .env
    php artisan key:generate --ansi
fi

# 4. Application optimization
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

# Only create storage link if it doesn't exist
if [ ! -L "public/storage" ]; then
    php artisan storage:link
fi

# Final permission check
fix-permissions

# 5. Health check before starting
if [ -f "vendor/autoload.php" ] && [ -w storage ] && [ -w bootstrap/cache ]; then
    echo "✅ System ready! Starting PHP-FPM..."
    exec php-fpm -F -R
else
    echo "❌ Critical: System not ready for startup"
    exit 1
fi