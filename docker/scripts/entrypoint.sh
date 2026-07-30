#!/bin/bash
set -euo pipefail

APP_DIR=/var/www/html

mkdir -p "$APP_DIR/storage/logs" "$APP_DIR/storage/framework/cache" "$APP_DIR/storage/framework/sessions" "$APP_DIR/storage/framework/views" "$APP_DIR/bootstrap/cache" "$APP_DIR/public/uploads"

: "${APP_KEY:?APP_KEY must be set in the deployment .env file}"
: "${DB_DATABASE:?DB_DATABASE must be set in the deployment .env file}"
: "${DB_USERNAME:?DB_USERNAME must be set in the deployment .env file}"
: "${DB_PASSWORD:?DB_PASSWORD must be set in the deployment .env file}"

php "$APP_DIR/artisan" config:clear >/dev/null 2>&1 || true
php "$APP_DIR/artisan" storage:link >/dev/null 2>&1 || true

if [ "${APP_ENV:-production}" = "production" ]; then
  php "$APP_DIR/artisan" config:cache >/dev/null 2>&1 || true
  php "$APP_DIR/artisan" route:cache >/dev/null 2>&1 || true
  php "$APP_DIR/artisan" view:cache >/dev/null 2>&1 || true
  php "$APP_DIR/artisan" event:cache >/dev/null 2>&1 || true
fi

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
  export MYSQL_PWD="$DB_PASSWORD"
  table_count="$(mysql --protocol=TCP --host="${DB_HOST:?}" --port="${DB_PORT:?}" --user="$DB_USERNAME" --skip-column-names --batch -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '${DB_DATABASE}';")"
  unset MYSQL_PWD

  if [ "$table_count" = "0" ]; then
    php "$APP_DIR/artisan" migrate --seed --force --no-interaction
  fi
fi

php "$APP_DIR/artisan" optimize >/dev/null 2>&1 || true

exec "$@"
