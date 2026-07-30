# Despliegue de RiskGuard TI en Ubuntu con Docker

Esta configuración ejecuta PHP-FPM, Nginx, MySQL, Redis, cola y scheduler en
contenedores separados. No instala PHP, Composer, Node, MySQL, Redis ni Nginx
en el host.

## Preparación

1. Instala Docker Engine, el plugin Docker Compose y Git en Ubuntu. Clona el
   repositorio, por ejemplo en `/srv/riskguard/app`.
2. Crea directorios persistentes para los respaldos, archivos de Laravel y
   uploads. Asígnalos al usuario `www-data` (UID 33) del contenedor, sin usar
   permisos 777:

   ```bash
   cd /srv/riskguard/app
   sudo install -d -o 33 -g 33 -m 0750 /srv/riskguard/backups/mysql
   sudo install -d -o 33 -g 33 -m 0775 storage public/uploads
   cp .env.production.example .env
   chmod 600 .env
   ```

3. Edita exclusivamente `.env`. Cambia todas las claves `CHANGE_ME`, el dominio,
   `BACKUP_PATH` y la URL. Genera una sola vez la clave Laravel, sin instalar PHP
   en el host:

   ```bash
   docker compose --env-file .env -f docker-compose.prod.yml build app
   docker compose --env-file .env -f docker-compose.prod.yml run --rm --no-deps --entrypoint php app artisan key:generate --show
   ```

   Copia el resultado en `APP_KEY`. No cambies esa clave después del primer
   despliegue.

4. Despliega:

   ```bash
   docker compose --env-file .env -f docker-compose.prod.yml up -d --build
   docker compose --env-file .env -f docker-compose.prod.yml ps
   ```

La aplicación queda disponible en `http://IP_DEL_SERVIDOR:HTTP_PORT`. El puerto
solo debe permitirse desde la LAN mediante UFW; no se requiere abrirlo en el
router para Cloudflare Tunnel.

La plantilla usa `LOG_STACK=daily,stderr`: Laravel conserva los registros en
`storage/logs` y también los emite con `docker compose ... logs app`.

## Cloudflare Tunnel

En la configuración de `cloudflared` instalada en el host, apunta el hostname
público al listener local:

```yaml
ingress:
  - hostname: riskguard.midominio.com
    service: http://127.0.0.1:8080
  - service: http_status:404
```

Si quieres acceso LAN y Tunnel, deja `HTTP_BIND_ADDRESS=0.0.0.0` y limita el
puerto con UFW a la subred local. Si solo usarás el túnel, usa
`HTTP_BIND_ADDRESS=127.0.0.1`.

Cloudflare termina TLS y reenvía `X-Forwarded-Proto`. Laravel no fuerza ningún
esquema; confía en los proxies definidos por `TRUSTED_PROXIES` y usa el protocolo
recibido. Para el acceso LAN usa `APP_URL=http://IP_LOCAL:PUERTO` y
`SESSION_SECURE_COOKIE=false`; para el dominio público usa la URL HTTPS y
cookies seguras. Son cambios de `.env`, sin recompilar la imagen.

## Volúmenes y actualizaciones

`mysql_data`, `redis_data` y `app_bootstrap` son volúmenes Docker persistentes.
Los logs, archivos de Laravel y uploads viven respectivamente en `storage/` y
`public/uploads/` del checkout; ambos están ignorados por Git. `docker compose
down` no borra ninguno. Nunca ejecutes `docker compose down -v` en producción.

`app_code` es el único volumen reemplazable: es la única fuente de código
compartida, montada de solo lectura por PHP y Nginx. Para actualizar el checkout
e imagen sin tocar información persistente:

```bash
git pull --ff-only
bash docker/scripts/deploy-production.sh
```

El script reemplaza solo `app_code`; no borra la base de datos, archivos subidos,
Redis ni respaldos.

## Migraciones y respaldos

Con `RUN_MIGRATIONS=true`, el contenedor `app` ejecuta `migrate --seed` solo si
la base de datos no contiene tablas. Después del primer arranque, deja esta
variable en `false` y ejecuta migraciones revisadas manualmente durante cada
despliegue:

```bash
docker compose --env-file .env -f docker-compose.prod.yml exec -T app php artisan migrate --force
```

El backup se escribe en `BACKUP_PATH`, fuera de los contenedores y del repositorio:

```bash
docker compose --env-file .env -f docker-compose.prod.yml exec -T -e BACKUP_DIR=/backups -e RETENTION_DAYS=30 app bash docker/scripts/backup-mysql.sh
```

Programa el mismo comando en el crontab del usuario administrador, por ejemplo a
las 02:00, redirigiendo su salida a un archivo del host. Restaura primero en un
entorno de prueba y, cuando corresponda:

```bash
docker compose --env-file .env -f docker-compose.prod.yml exec -T app bash docker/scripts/restore-mysql.sh /backups/ARCHIVO.sql.gz
```
