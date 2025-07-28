#!/bin/bash
set -e  # Sai imediatamente se qualquer comando falhar

# ==============================================
# 1. CONFIGURAÇÃO DE USUÁRIO/GROPO
# ==============================================
if [ -n "$USER_ID" ] && [ -n "$GROUP_ID" ]; then
    echo "🔄 Configurando usuário www-data para UID: $USER_ID e GID: $GROUP_ID"
    usermod -u "$USER_ID" www-data
    groupmod -g "$GROUP_ID" www-data
fi

# ==============================================
# 2. INSTALAÇÃO DE DEPENDÊNCIAS
# ==============================================
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "📦 Instalando dependências do Composer..."
    
    if [ -f "composer.lock" ]; then
        composer install \
            --no-interaction \
            --prefer-dist \
            --optimize-autoloader \
            --no-dev \
            --no-scripts
    else
        composer update \
            --no-interaction \
            --prefer-dist \
            --optimize-autoloader \
            --no-dev \
            --no-scripts
    fi
    
    # Executa scripts pós-instalação
    composer run-script post-install-cmd
fi

# ==============================================
# 3. CONFIGURAÇÃO DO AMBIENTE
# ==============================================
if [ ! -f ".env" ]; then
    echo "⚙️ Criando arquivo .env..."
    cp .env.example .env
    
    if [ -f ".env" ]; then
        echo "🔑 Gerando chave de aplicação..."
        php artisan key:generate --ansi
    fi
elif ! grep -q '^APP_KEY=' .env || grep -q '^APP_KEY=$' .env; then
    echo "🔑 Gerando chave de aplicação (existente mas vazia)..."
    php artisan key:generate --ansi
fi

# ==============================================
# 4. CONFIGURAÇÃO DE PERMISSÕES
# ==============================================
echo "🔒 Configurando permissões..."

# Cria diretórios essenciais
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Configura ACL para permissões persistentes
setfacl -R -d -m u:www-data:rwX,g:www-data:rwX storage bootstrap/cache
setfacl -R -m u:www-data:rwX,g:www-data:rwX storage bootstrap/cache

# Permissões específicas para otimização
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# ==============================================
# 5. OTIMIZAÇÃO DO LARAVEL
# ==============================================
echo "⚡ Otimizando aplicação Laravel..."

# Limpeza de cache
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

# Cache de configurações (apenas em produção)
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# ==============================================
# 6. BANCO DE DADOS (OPCIONAL)
# ==============================================
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "🛠️ Executando migrações do banco de dados..."
    php artisan migrate --force
    
    if [ "$SEED_DATABASE" = "true" ]; then
        echo "🌱 Executando seeders..."
        php artisan db:seed --force
    fi
fi

# ==============================================
# 7. INICIALIZAÇÃO DO SERVIDOR
# ==============================================
if [ "$APP_ENV" = "local" ]; then
    echo "🔄 Verificando assets do Vite..."
    if [ ! -f "public/build/manifest.json" ]; then
        echo "⚠️ Manifesto Vite não encontrado. Execute manualmente:"
        echo "docker compose exec vite npm run build"
    fi
fi
exec php-fpm