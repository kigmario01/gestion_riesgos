#!/bin/bash
set -euo pipefail

BACKUP_DIR="${BACKUP_DIR:?BACKUP_DIR must be set}"
RETENTION_DAYS="${RETENTION_DAYS:-30}"

find "$BACKUP_DIR" -type f -name "*.sql.gz" -mtime +"$RETENTION_DAYS" -delete
