FROM php:8.3-fpm

# 1. Instalação de dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libjpeg-dev libfreetype6-dev gnupg acl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Instalação do Node.js (versão LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && rm -rf /var/lib/apt/lists/*

# 3. Instalação do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4. Configuração do PHP-FPM
RUN sed -i \
    -e 's/listen = 127.0.0.1:9000/listen = 9000/' \
    -e 's/;listen.owner = www-data/listen.owner = www-data/' \
    -e 's/;listen.group = www-data/listen.group = www-data/' \
    /usr/local/etc/php-fpm.d/www.conf

# 5. Preparação do ambiente Laravel
WORKDIR /var/www
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 6. Configuração do entrypoint
COPY entrypoints.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoints.sh

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoints.sh"]