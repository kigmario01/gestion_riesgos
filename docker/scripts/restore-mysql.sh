#!/bin/bash
set -euo pipefail

BACKUP_FILE="${1:-}"
DB_NAME="${DB_DATABASE:-riskguard}"
DB_USER="${DB_USERNAME:-riskguard}"
DB_PASSWORD="${DB_PASSWORD:-riskguard}"
DB_HOST="${DB_HOST:-mysql}"

if [ -z "$BACKUP_FILE" ]; then
  echo "Usage: $0 <backup-file>"
  exit 1
fi

mysql --host="$DB_HOST" --user="$DB_USER" --password="$DB_PASSWORD" "$DB_NAME" < "$BACKUP_FILE"
