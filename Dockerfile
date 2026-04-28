FROM php:8.3-cli-alpine

# System dependencies
RUN apk add --no-cache \
    git curl zip unzip \
    libpng-dev libzip-dev libxml2-dev oniguruma-dev \
    freetype-dev libjpeg-turbo-dev \
    postgresql-dev \
    nodejs npm

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_mysql pdo_pgsql pgsql \
        mbstring bcmath gd zip xml pcntl opcache

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
    && chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

EXPOSE 8000

CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php -S 0.0.0.0:${PORT:-8000} -t public public/index.php
