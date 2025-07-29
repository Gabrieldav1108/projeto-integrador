#!/bin/bash
set -e

echo "🚀 Starting Laravel Auto-Setup..."

# Função para aplicar permissões
apply_permissions() {
    echo "🔧 Applying automatic permission fixes..."
    
    # Usa UID/GID do host ou valores padrão
    local HOST_UID=${HOST_UID:-1000}
    local HOST_GID=${HOST_GID:-1000}
    
    # Diretórios críticos com permissões específicas
    for dir in storage bootstrap/cache; do
        if [ -d "/var/www/$dir" ]; then
            chown -R $HOST_UID:$HOST_GID "/var/www/$dir"
            chmod -R 775 "/var/www/$dir"
            echo "✓ Permissions set for $dir"
        fi
    done
    
    # Arquivo .env com permissões específicas
    [ -f "/var/www/.env" ] && chmod 664 "/var/www/.env" && echo "✓ Permissions set for .env"
    
    # Garante que o usuário tem acesso aos diretórios
    chown -R $HOST_UID:$HOST_GID /var/www/vendor
    chmod -R 775 /var/www/vendor
    
    echo "✅ Automatic permission fixes completed"
}

# 1. Cria estrutura de diretórios
echo "📂 Ensuring directory structure..."
mkdir -p \
    storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache \
    public/storage

# Aplica permissões iniciais
apply_permissions

# 2. Instalação de dependências com lógica de repetição
install_dependencies() {
    local max_retries=3
    local attempt=0
    local delay=10
    
    while [ $attempt -lt $max_retries ]; do
        ((attempt++))
        echo "📦 Installing dependencies (attempt $attempt/$max_retries)..."
        
        if composer install --no-interaction --prefer-dist --optimize-autoloader; then
            # Atualiza permissões após instalação
            apply_permissions
            return 0
        fi
        
        echo "⚠️ Attempt $attempt failed, retrying in $delay seconds..."
        sleep $delay
    done
    
    return 1
}

# Verifica status do Vite
check_vite() {
    if ! curl -s http://vite:5173 >/dev/null; then
        echo "⚠️ Vite server is not responding - assets may not load!"
        echo "ℹ️ Run 'docker-compose up vite' in another terminal if needed"
    else
        echo "✓ Vite server is running"
    fi
}

# Executa verificações
check_vite

# Instala dependências se necessário
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    install_dependencies || {
        echo "❌ Failed to install dependencies after maximum attempts"
        exit 1
    }
fi

# 3. Configuração do ambiente
if [ ! -f ".env" ]; then
    echo "⚙️ Initializing environment..."
    cp .env.example .env
    php artisan key:generate --ansi
    apply_permissions
fi

# 4. Otimização da aplicação
echo "⚡ Optimizing application..."
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

# Cria link de storage se não existir
if [ ! -L "public/storage" ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
    apply_permissions
fi

# Verificação final de saúde
echo "🔍 Running final health checks..."
if [ -f "vendor/autoload.php" ] && [ -w storage ] && [ -w bootstrap/cache ]; then
    echo "✓ Vendor autoload OK"
    echo "✓ Storage directory writable"
    echo "✓ Bootstrap cache writable"
    
    # Aplica permissões finais
    apply_permissions
    
    echo "✅ System ready! Starting PHP-FPM..."
    exec php-fpm -F -R
else
    echo "❌ Critical: System not ready for startup"
    echo "ℹ️ Check the following:"
    echo " - vendor/autoload.php exists"
    echo " - storage directory is writable"
    echo " - bootstrap/cache is writable"
    exit 1
fi