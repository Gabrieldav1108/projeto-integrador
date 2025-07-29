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

# Create permission fix script
RUN echo '#!/bin/bash\n\
set -e\n\
echo "🔧 Applying automatic permission fixes..."\n\
\n\
# Use host UID/GID from environment or defaults\n\
HOST_UID=${HOST_UID:-1000}\n\
HOST_GID=${HOST_GID:-1000}\n\
\n\
# Apply permissions to critical directories\n\
for dir in storage bootstrap/cache; do\n\
    if [ -d "/var/www/$dir" ]; then\n\
        chown -R laravel:laravel "/var/www/$dir" || true\n\
        chmod -R 775 "/var/www/$dir" || true\n\
    fi\n\
done\n\
\n\
# Special handling for .env\n\
[ -f "/var/www/.env" ] && chmod 664 "/var/www/.env" || true\n\
\n\
echo "✅ Automatic permission fixes applied"' > /usr/local/bin/fix-permissions && \
    chmod +x /usr/local/bin/fix-permissions

WORKDIR /var/www

USER laravel

# Entrypoint script
COPY --chown=laravel:laravel entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]