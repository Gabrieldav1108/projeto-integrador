FROM php:8.3-fpm

# 1. Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libjpeg-dev libfreetype6-dev gnupg acl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Configure usuário e permissões
RUN groupadd -g 1000 laravel && \
    useradd -u 1000 -g laravel -m laravel && \
    mkdir -p /var/www && \
    chown -R laravel:laravel /var/www

# 4. Configure o Git para permitir o diretório
RUN git config --global --add safe.directory /var/www

# 5. Configure o PHP-FPM
RUN sed -i \
    -e 's/listen = .*/listen = 9000/' \
    -e 's/user = www-data/user = laravel/' \
    -e 's/group = www-data/group = laravel/' \
    /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www

# 6. Copie os arquivos do composer primeiro
COPY --chown=laravel:laravel composer.json composer.lock ./

# 7. Instale dependências como usuário laravel
USER laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# 8. Copie o resto da aplicação
COPY --chown=laravel:laravel . .

# 9. Execute apenas o dump-autoload (removemos o run-script)
RUN composer dump-autoload --optimize

# 10. Configure entrypoint
COPY --chown=laravel:laravel entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]