# Imagen base oficial de PHP con FPM
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev libonig-dev libxml2-dev libssl-dev libcurl4-openssl-dev libsqlite3-dev libpq-dev \
    zip unzip git curl vim jpegoptim optipng pngquant gifsicle locales && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP (incluye PostgreSQL)
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip exif pcntl bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

# Instalar dependencias del proyecto (PHP + frontend)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader && \
    npm ci && \
    npm run build

# Asignar permisos
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Exponer puerto
EXPOSE 8000

# Comando para iniciar la app
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
