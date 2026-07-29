# syntax=docker/dockerfile:1.7

FROM composer:2.8 AS vendor
WORKDIR /src
COPY composer.json composer.lock* ./
RUN composer install --no-interaction --prefer-dist --no-progress --no-dev --optimize-autoloader --no-scripts

FROM node:22-alpine AS frontend
WORKDIR /src
COPY package*.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

FROM php:8.3-fpm-bookworm AS production

ENV APP_ENV=production \
    APP_DEBUG=false \
    PHP_OPCACHE_ENABLE=1 \
    PHP_OPCACHE_MEMORY_CONSUMPTION=128 \
    PHP_OPCACHE_VALIDATE_TIMESTAMPS=0 \
    PHP_OPCACHE_REVALIDATE_FREQ=0 \
    PHP_UPLOAD_MAX_FILESIZE=20M \
    PHP_POST_MAX_SIZE=20M \
    PHP_MAX_EXECUTION_TIME=60

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        unzip \
        zip \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libicu-dev \
        libzip-dev \
        libpq-dev \
        default-mysql-client \
        procps \
        supervisor \
        logrotate \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql pcntl mbstring bcmath gd zip opcache intl pdo_pgsql pgsql \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/cache/apt/archives /var/lib/apt/lists/*

COPY . .
COPY --from=vendor /src/vendor ./vendor
COPY --from=frontend /src/public/build ./public/build

RUN chmod +x \
    /var/www/html/docker/scripts/entrypoint.sh \
    /var/www/html/docker/scripts/backup-mysql.sh \
    /var/www/html/docker/scripts/restore-mysql.sh \
    /var/www/html/docker/scripts/cleanup-backups.sh

RUN php artisan package:discover --ansi

RUN cp docker/php/php.ini /usr/local/etc/php/php.ini \
    && cp docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf \
    && cp docker/php/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf \
    && cp docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini \
    && cp docker/logrotate/riskguard.conf /etc/logrotate.d/riskguard \
    && cp docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache public/uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache public/uploads \
    && find /var/www/html -type d -exec chmod 755 {} + \
    && find /var/www/html -type f -exec chmod 644 {} +

EXPOSE 9000

HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=3 CMD php-fpm -t >/dev/null || exit 1

ENTRYPOINT ["/bin/bash", "/var/www/html/docker/scripts/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
