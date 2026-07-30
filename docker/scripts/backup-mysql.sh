#!/bin/bash
set -euo pipefail

BACKUP_DIR="${BACKUP_DIR:?BACKUP_DIR must be set}"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="${DB_DATABASE:?DB_DATABASE must be set}"
DB_USER="${DB_USERNAME:?DB_USERNAME must be set}"
DB_PASSWORD="${DB_PASSWORD:?DB_PASSWORD must be set}"
DB_HOST="${DB_HOST:?DB_HOST must be set}"
DB_PORT="${DB_PORT:?DB_PORT must be set}"

umask 077
mkdir -p "$BACKUP_DIR"

export MYSQL_PWD="$DB_PASSWORD"
mysqldump --single-transaction --quick --routines --events --host="$DB_HOST" --port="$DB_PORT" --user="$DB_USER" "$DB_NAME" | gzip > "$BACKUP_DIR/${DB_NAME}_${DATE}.sql.gz"
unset MYSQL_PWD

find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +"${RETENTION_DAYS:-30}" -delete
