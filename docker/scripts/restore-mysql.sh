#!/bin/bash
set -euo pipefail

BACKUP_FILE="${1:-}"
DB_NAME="${DB_DATABASE:?DB_DATABASE must be set}"
DB_USER="${DB_USERNAME:?DB_USERNAME must be set}"
DB_PASSWORD="${DB_PASSWORD:?DB_PASSWORD must be set}"
DB_HOST="${DB_HOST:?DB_HOST must be set}"
DB_PORT="${DB_PORT:?DB_PORT must be set}"

if [ -z "$BACKUP_FILE" ]; then
  echo "Usage: $0 <backup-file>"
  exit 1
fi

export MYSQL_PWD="$DB_PASSWORD"
if [[ "$BACKUP_FILE" == *.gz ]]; then
  gzip -dc "$BACKUP_FILE" | mysql --host="$DB_HOST" --port="$DB_PORT" --user="$DB_USER" "$DB_NAME"
else
  mysql --host="$DB_HOST" --port="$DB_PORT" --user="$DB_USER" "$DB_NAME" < "$BACKUP_FILE"
fi
unset MYSQL_PWD
