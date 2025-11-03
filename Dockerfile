# ================================
# Etapa 1: Compilación de assets (Node)
# ================================
FROM node:20-alpine AS build

WORKDIR /app
COPY package*.json ./
COPY vite.config.js ./
COPY scripts ./scripts
COPY resources ./resources

RUN npm ci && npm run build

# ================================
# Etapa 2: Aplicación Laravel (PHP)
# ================================
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libpq-dev zip unzip git curl && \
    docker-php-ext-install pdo pdo_pgsql bcmath gd && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Copia el build real desde la primera etapa
COPY --from=build /app/public/build ./public/build

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

RUN mkdir -p /var/www/storage/framework/{cache,sessions,views} && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/public

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
