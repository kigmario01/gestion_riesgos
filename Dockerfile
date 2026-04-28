FROM php:8.3-fpm-alpine

# System dependencies
RUN apk add --no-cache \
    git curl zip unzip \
    libpng-dev libzip-dev libxml2-dev oniguruma-dev \
    freetype-dev libjpeg-turbo-dev \
    postgresql-dev \
    nginx supervisor \
    nodejs npm

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_mysql pdo_pgsql pgsql \
        mbstring bcmath gd zip xml pcntl opcache fpm

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Install PHP dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# Install Node dependencies and build frontend
COPY package.json package-lock.json ./
RUN npm ci

COPY . .

RUN npm run build

# Permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache /app 2>/dev/null || true

# Nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Supervisor config
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 8000

CMD ["/bin/sh", "-c", "php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force && php artisan db:seed --force && supervisord -c /etc/supervisord.conf"]
