FROM php:8.2-cli-alpine

# Dependencias del sistema
RUN apk add --no-cache \
    git curl zip unzip \
    libpng-dev libzip-dev libxml2-dev oniguruma-dev \
    postgresql-dev \
    nodejs npm

# Extensiones PHP
RUN docker-php-ext-install \
    pdo pdo_mysql pdo_pgsql \
    mbstring bcmath gd zip xml pcntl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Instalar dependencias PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Instalar dependencias Node
COPY package.json package-lock.json ./
RUN npm ci

# Copiar el resto del proyecto
COPY . .

# Build del frontend
RUN npm run build

# Permisos de storage
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

EXPOSE 8000

CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
