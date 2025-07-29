FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libjpeg-dev libfreetype6-dev gnupg acl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure system
RUN groupadd -g 1000 laravel && \
    useradd -u 1000 -g laravel -m laravel && \
    mkdir -p /var/www && \
    chown -R laravel:laravel /var/www

# Configure Git safe directory
RUN git config --global --add safe.directory /var/www

# Configure PHP-FPM
RUN sed -i \
    -e 's/listen = .*/listen = 9000/' \
    -e 's/user = www-data/user = laravel/' \
    -e 's/group = www-data/group = laravel/' \
    /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www
COPY --chown=laravel:laravel . .

# Install dependencies as root first
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

USER laravel

# Entrypoint script
COPY --chown=laravel:laravel entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]