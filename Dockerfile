# Etapa 1: compilación de assets (Node)
FROM node:20-alpine as build

WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
RUN npm run build


# Etapa 2: aplicación Laravel (PHP)
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libpq-dev zip unzip git curl && \
    docker-php-ext-install pdo pdo_pgsql bcmath gd && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Copiar el build de Node desde la primera etapa
COPY --from=build /app/public/build ./public/build

# Instalar dependencias PHP (sin dev)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Crear carpetas necesarias
RUN mkdir -p /var/www/storage/framework/{cache,sessions,views} && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/public

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
