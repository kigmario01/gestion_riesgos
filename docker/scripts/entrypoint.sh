#!/bin/bash
set -euo pipefail

APP_DIR=/var/www/html

if [ ! -f "$APP_DIR/.env" ]; then
  cp "$APP_DIR/.env.example" "$APP_DIR/.env"
fi

mkdir -p "$APP_DIR/storage/logs" "$APP_DIR/storage/framework/cache" "$APP_DIR/storage/framework/sessions" "$APP_DIR/storage/framework/views" "$APP_DIR/bootstrap/cache" "$APP_DIR/public/uploads"

chown -R www-data:www-data "$APP_DIR/storage" "$APP_DIR/bootstrap/cache" "$APP_DIR/public/uploads" "$APP_DIR/.env"

php "$APP_DIR/artisan" config:clear >/dev/null 2>&1 || true
php "$APP_DIR/artisan" config:cache >/dev/null 2>&1 || true
php "$APP_DIR/artisan" route:cache >/dev/null 2>&1 || true
php "$APP_DIR/artisan" view:cache >/dev/null 2>&1 || true
php "$APP_DIR/artisan" event:cache >/dev/null 2>&1 || true
php "$APP_DIR/artisan" optimize >/dev/null 2>&1 || true

exec "$@"
