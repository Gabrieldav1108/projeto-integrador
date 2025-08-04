FROM php:8.2-cli


# Instala dependências
RUN apt-get update && apt-get install -y \
git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev curl \
&& curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
&& apt-get install -y nodejs \
&& docker-php-ext-install pdo_mysql mbstring zip

RUN git config --global --add safe.directory /var/www

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto
COPY . .

# Instala dependências PHP do Laravel
RUN composer install

# Limpa cache de config
RUN php artisan config:clear

# Expondo a porta 8080
EXPOSE 8080

RUN npm install && npm run build

# Comando para iniciar o Laravel
CMD ["/bin/sh", "-c", "\
    if [ ! -f .env ]; then cp .env.example .env; fi && \
    composer install && \
    npm install && npm run build && \
    php artisan key:generate --force && \
    php artisan serve --host=0.0.0.0 --port=8080"]
