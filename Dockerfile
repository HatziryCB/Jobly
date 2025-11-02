# Imagen base oficial de PHP con FPM
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    libsqlite3-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    vim \
    jpegoptim optipng pngquant gifsicle \
    locales

# Instalar extensiones de PHP (incluye PostgreSQL)
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring zip exif pcntl bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias PHP del proyecto
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Asignar permisos adecuados
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Exponer puerto 8000 (Laravel sirve en este puerto)
EXPOSE 8000

# Limpiar caché antes de iniciar
RUN php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear

# Comando para iniciar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
