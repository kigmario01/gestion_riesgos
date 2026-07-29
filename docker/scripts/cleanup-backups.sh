#!/bin/bash
set -euo pipefail

BACKUP_DIR="${BACKUP_DIR:-/opt/riskguard/backups/mysql}"
RETENTION_DAYS="${RETENTION_DAYS:-30}"

find "$BACKUP_DIR" -type f -name "*.sql" -mtime +"$RETENTION_DAYS" -delete
