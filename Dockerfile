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

# Create application user
RUN groupadd -g ${GID} laravel && \
    useradd -u ${UID} -g laravel -m laravel

WORKDIR /var/www

# Copy application files
COPY --chown=laravel:laravel . .

USER laravel