FROM php:8.4-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    zip unzip curl git libzip-dev libonig-dev libpng-dev libxml2-dev gnupg \
    && docker-php-ext-install pdo_mysql mbstring zip exif

# Instalar Node.js 20.x (recomendado para Laravel + Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Verifica se Node e NPM estão disponíveis
RUN node -v && npm -v

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www/html
