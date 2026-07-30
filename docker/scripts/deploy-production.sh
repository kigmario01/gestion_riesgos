#!/bin/bash
set -euo pipefail

COMPOSE_FILE=docker-compose.prod.yml
ENV_FILE=.env

if [ ! -f "$ENV_FILE" ]; then
  echo "Missing $ENV_FILE. Copy .env.production.example and set its values first." >&2
  exit 1
fi

set -a
. "./$ENV_FILE"
set +a

: "${COMPOSE_PROJECT_NAME:?COMPOSE_PROJECT_NAME must be set in .env}"

# Only the immutable shared code volume is replaced. Database, Redis, uploads,
# logs and cache volumes are deliberately left intact.
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" down
docker volume rm "${COMPOSE_PROJECT_NAME}_app_code" 2>/dev/null || true
docker compose --env-file "$ENV_FILE" -f "$COMPOSE_FILE" up -d --build
