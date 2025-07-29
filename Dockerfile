FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libjpeg-dev libfreetype6-dev gnupg acl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure PHP-FPM
RUN sed -i \
    -e 's/listen = .*/listen = 9000/' \
    -e 's/;listen.owner = .*/listen.owner = www-data/' \
    -e 's/;listen.group = .*/listen.group = www-data/' \
    /usr/local/etc/php-fpm.d/www.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create application user and set permissions
RUN groupadd -g ${GID} laravel && \
    useradd -u ${UID} -g laravel -m laravel && \
    mkdir -p /var/www/storage /var/www/bootstrap/cache && \
    chown -R laravel:laravel /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Permission fix script
RUN echo '#!/bin/bash\n\
set -e\n\
echo "🔧 Applying automatic permission fixes..."\n\
chown -R laravel:laravel /var/www/storage /var/www/bootstrap/cache\n\
chmod -R 775 /var/www/storage /var/www/bootstrap/cache\n\
[ -f "/var/www/.env" ] && chmod 664 "/var/www/.env"\n\
echo "✅ Permissions applied"' > /usr/local/bin/fix-permissions && \
    chmod +x /usr/local/bin/fix-permissions

WORKDIR /var/www

COPY --chown=laravel:laravel . .

USER laravel

# Entrypoint script
COPY --chown=laravel:laravel entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]