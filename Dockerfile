FROM php:8.3-fpm

# Instalar dependências do sistema e Node.js
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip curl git npm

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar projeto
COPY . .

# Instalar dependências do Laravel
RUN composer install

# Instalar e buildar frontend (Bootstrap/Vite/Breeze)
RUN npm install && npm install sass && npm run build

# Permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]