FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

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
RUN groupadd -g $GID laravel || true && \
    useradd -u $UID -g $GID -m laravel || true && \
    mkdir -p /var/www/vendor && \
    chown -R $UID:$GID /var/www

# 4. Configure o PHP-FPM
RUN sed -i \
    -e 's/listen = .*/listen = 9000/' \
    -e 's/user = www-data/user = laravel/' \
    -e 's/group = www-data/group = laravel/' \
    /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www

# 5. Copie os arquivos do composer primeiro
COPY --chown=${UID}:${GID} composer.json composer.lock ./

# 6. Instale dependências como root (durante o build)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# 7. Ajuste as permissões novamente
RUN chown -R ${UID}:${GID} /var/www/vendor

# 8. Mude para o usuário laravel
USER laravel

# 9. Copie o resto da aplicação
COPY --chown=${UID}:${GID} . .

# 10. Configure entrypoint
COPY --chown=${UID}:${GID} entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]