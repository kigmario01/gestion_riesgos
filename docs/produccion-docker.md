# RiskGuard TI - Infraestructura Docker para producción

## Resumen ejecutivo

Este rediseño convierte RiskGuard TI en una aplicación preparada para despliegue en un servidor Ubuntu con Docker Engine, usando contenedores separados para:

- PHP-FPM + Laravel
- Nginx
- MySQL
- Redis

La arquitectura separa la aplicación, los datos, la caché y los logs para mejorar seguridad, capacidad de mantenimiento y recuperación ante fallos.

## Decisiones clave

### 1. Separación de servicios
Cada componente tiene un rol claro y se ejecuta en un contenedor independiente:

- app: procesa PHP y ejecuta Laravel.
- nginx: entrega HTTP y aplica headers de seguridad.
- mysql: almacena la base de datos relacional.
- redis: gestiona sesiones, caché y colas.

### 2. Persistencia
Los datos críticos se guardan en volúmenes Docker para que sobrevivan a recreaciones del stack.

### 3. Sin migraciones automáticas
El arranque del contenedor no ejecuta migraciones ni seeders. Eso evita cambios no controlados y facilita despliegues seguros.

### 4. Logs persistentes
Los logs se almacenan en volúmenes y se pueden rotar con logrotate.

### 5. Seguridad
Se utiliza un usuario no root en la imagen PHP, se limita el tamaño de subida, se deshabilitan errores en producción y se exponen solo los puertos necesarios.

## Estructura esperada en el servidor

/opt/riskguard
├── app
├── docker
│   ├── nginx
│   ├── php
│   ├── mysql
│   ├── supervisor
│   └── scripts
├── backups
├── logs
├── storage
├── compose
├── .env
└── docker-compose.yml

## Despliegue recomendado

1. Preparar el directorio del servidor.
2. Copiar el proyecto a /opt/riskguard/app.
3. Copiar el archivo docker-compose.yml y la carpeta docker.
4. Definir el archivo .env con valores reales.
5. Ejecutar:

   docker compose up -d --build

6. Ejecutar migraciones manualmente:

   docker compose exec app php artisan migrate --force

7. Ejecutar seeders si es necesario:

   docker compose exec app php artisan db:seed --force

## Backup

Los backups de MySQL se generan con:

   docker compose exec app bash /var/www/html/docker/scripts/backup-mysql.sh

## Restauración

   docker compose exec app bash /var/www/html/docker/scripts/restore-mysql.sh /path/to/backup.sql
