#!/bin/bash
set -euo pipefail

BACKUP_DIR="${BACKUP_DIR:-/opt/riskguard/backups/mysql}"
DATE=$(date +%Y%m%d_%H%M%S)
DB_NAME="${DB_DATABASE:-riskguard}"
DB_USER="${DB_USERNAME:-riskguard}"
DB_PASSWORD="${DB_PASSWORD:-riskguard}"
DB_HOST="${DB_HOST:-mysql}"

mkdir -p "$BACKUP_DIR"

mysqldump --host="$DB_HOST" --user="$DB_USER" --password="$DB_PASSWORD" "$DB_NAME" > "$BACKUP_DIR/${DB_NAME}_${DATE}.sql"

find "$BACKUP_DIR" -type f -name "*.sql" -mtime +7 -delete
