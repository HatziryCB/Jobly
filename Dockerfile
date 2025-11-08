FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Node directamente en esta imagen
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

WORKDIR /var/www
COPY . .

# Instalar dependencias PHP y Node y compilar Vite
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader \
    && npm ci \
    && npm run build

RUN mkdir -p storage/framework/{cache,sessions,views} \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/public

EXPOSE 8000

RUN php artisan migrate --force

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
