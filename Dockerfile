# ================================
# Etapa 1: Compilación de assets (Node)
# ================================
FROM node:20-alpine AS build

WORKDIR /app

# Copiar archivos de dependencias
COPY package*.json ./

# Instalar dependencias de frontend
RUN npm ci

# Copiar recursos y configuración de Vite
COPY resources ./resources
COPY vite.config.js ./
COPY scripts ./scripts
COPY package.json ./

# Compilar los assets (usa el script fixManifest)
RUN npm run build


# ================================
# Etapa 2: Aplicación Laravel (PHP)
# ================================
FROM php:8.2-fpm

# Instalar dependencias del sistema necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libpq-dev zip unzip git curl && \
    docker-php-ext-install pdo pdo_pgsql bcmath gd && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorio de trabajo
WORKDIR /var/www

# Copiar el proyecto completo
COPY . .

# Copiar el build compilado desde la primera etapa
COPY --from=build /app/public/build ./public/build

# Instalar dependencias PHP
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Crear las carpetas necesarias para cache y sesiones
RUN mkdir -p /var/www/storage/framework/{cache,sessions,views} && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/public

# Exponer el puerto para Laravel
EXPOSE 8000

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
