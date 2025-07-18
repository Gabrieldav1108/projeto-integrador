FROM php:8.3-fpm

# 1. Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libjpeg-dev libfreetype6-dev gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Instalar Node.js e npm (útil em dev)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# 3. Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4. Define diretório de trabalho
WORKDIR /var/www

# 5. Copiar entrypoint (responsável por instalar dependências e setar permissões)
COPY entrypoints.sh /usr/local/bin/entrypoints.sh
RUN chmod +x /usr/local/bin/entrypoints.sh

# 6. Configurar PHP-FPM para escutar corretamente
RUN sed -i 's|listen = 127.0.0.1:9000|listen = 9000|' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's|;listen.owner = www-data|listen.owner = www-data|' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's|;listen.group = www-data|listen.group = www-data|' /usr/local/etc/php-fpm.d/www.conf

# 7. Expor a porta do PHP-FPM
EXPOSE 9000

# 8. Executar script de inicialização
ENTRYPOINT ["entrypoints.sh"]