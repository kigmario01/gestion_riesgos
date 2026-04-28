# Guía: Optimizar Servidor Laravel para Concurrencia (Windows + XAMPP)

## El Problema
`php artisan serve` (runserver de Laravel) es **single-threaded** y no está diseñado para manejar múltiples requests simultáneos. Bajo carga concurrente, genera muchos **HTTP 500**.

## Solución: Cambiar de Servidor

### Opción 1: Usar Apache (RECOMENDADO para XAMPP)

**Ventaja**: Ya viene con XAMPP, multi-threaded, producción-ready  
**Desventaja**: Requiere configurar el .htaccess y virtualhost

#### Paso 1 — Configurar Virtual Host

**Archivo**: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`

Agrega al final:

```apache
<VirtualHost *:80>
    ServerName gestion-riesgos.local
    ServerAlias gestion-riesgos
    DocumentRoot "C:/xampp/htdocs/gestion_riesgos/public"
    
    <Directory "C:/xampp/htdocs/gestion_riesgos/public">
        AllowOverride All
        Require all granted
    </Directory>
    
    # Logs
    ErrorLog "logs/gestion_riesgos_error.log"
    CustomLog "logs/gestion_riesgos_access.log" common
</VirtualHost>
```

#### Paso 2 — Agregar al hosts de Windows

**Archivo**: `C:\Windows\System32\drivers\etc\hosts`

Agrega esta línea:
```
127.0.0.1  gestion-riesgos.local
```

#### Paso 3 — Habilitar Módulos en Apache

**Archivo**: `C:\xampp\apache\conf\httpd.conf`

Verifica que estas líneas **NO tengan #** (están descomentadas):

```apache
LoadModule rewrite_module modules/mod_rewrite.so
LoadModule vhost_alias_module modules/mod_vhost_alias.so
```

#### Paso 4 — Crear .htaccess en /public

**Archivo**: `C:\xampp\htdocs\gestion_riesgos\public\.htaccess`

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

#### Paso 5 — Reiniciar Apache

En **XAMPP Control Panel**:
1. Detén Apache
2. Inicia Apache nuevamente
3. Accede a `http://gestion-riesgos.local` en tu navegador

✅ **Resultado**: Laravel ahora corre bajo Apache multi-threaded

---

### Opción 2: Usar PHP Built-in Server con Múltiples Workers

**Ventaja**: No requiere Apache  
**Desventaja**: Solo es para desarrollo, no producción

En **PowerShell** (como admin):

```powershell
# Terminal 1
cd C:\xampp\htdocs\gestion_riesgos
php artisan serve --host=127.0.0.1 --port=8000

# Terminal 2
php artisan serve --host=127.0.0.1 --port=8001

# Terminal 3
php artisan serve --host=127.0.0.1 --port=8002
```

Luego usa un **Load Balancer** como nginx o un proxy. Esto es complejo, **NO RECOMENDADO** para pruebas simples.

---

### Opción 3: Usar HyperF (AVANZADO)

Si necesitas algo más robusto que el servidor built-in pero sin Apache, HyperF es una alternativa, pero requiere cambios en la estructura de Laravel.

**NO RECOMENDADO** para este proyecto.

---

## Configuración Recomendada: Apache

**Resumen de cambios**:

| Paso | Archivo | Cambio |
|------|---------|--------|
| 1 | `httpd-vhosts.conf` | Agregar Virtual Host |
| 2 | `C:\Windows\System32\drivers\etc\hosts` | Agregar entrada DNS local |
| 3 | `httpd.conf` | Descomenta módulos rewrite |
| 4 | `public/.htaccess` | Crear archivo |
| 5 | XAMPP Control | Reiniciar Apache |

---

## Verificar que Apache Funciona

1. En PowerShell:
```powershell
curl http://gestion-riesgos.local/
```

2. Deberías ver el HTML de tu aplicación Laravel (no error 404/500)

3. Ve a `http://gestion-riesgos.local/dashboard` y verifica que todo funcione

---

## Optimizaciones Adicionales en Apache

### Aumentar Max Connections
**Archivo**: `C:\xampp\apache\conf\extra\httpd-mpm_prefork_module.conf`

```apache
<IfModule mpm_prefork_module>
    StartServers        8
    MinSpareServers     5
    MaxSpareServers    20
    MaxRequestWorkers 256
    MaxConnectionsPerChild 0
</IfModule>
```

Este es mejor para concurrencia que el default.

### Comprimir Respuestas (Más Rápido)
**Archivo**: `C:\xampp\apache\conf\httpd.conf`

Descomenta:
```apache
LoadModule deflate_module modules/mod_deflate.so
```

Y agrega:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/json application/javascript
</IfModule>
```

---

## Para JMeter: Usa la URL Correcta

Si usas Apache con Virtual Host, cambia en JMeter:

**ANTES** (php artisan serve):
```
http://127.0.0.1:8000/activos
http://127.0.0.1:8000/dashboard
```

**AHORA** (Apache):
```
http://gestion-riesgos.local/activos
http://gestion-riesgos.local/dashboard
```

O simplemente:
```
http://localhost/activos
http://localhost/dashboard
```

---

## Verificar Rendimiento

### Ver Logs de Apache
```powershell
Get-Content C:\xampp\apache\logs\access.log -Tail 50
Get-Content C:\xampp\apache\logs\error.log -Tail 50
```

### Con JMeter bajo Concurrencia
Ejecuta tu plan de pruebas y verifica:
- ✅ Tasa de error < 2% (no debería haber 500 ni 419)
- ✅ Tiempo máximo < 2000 ms
- ✅ Tiempo promedio < 500 ms

---

## Troubleshooting

### Error 404 en gestion-riesgos.local
- [ ] Verifica que el Virtual Host esté en `httpd-vhosts.conf`
- [ ] Verifica que la entrada esté en `C:\Windows\System32\drivers\etc\hosts`
- [ ] Reinicia Apache (`XAMPP Control Panel` → Stop → Start)
- [ ] Borra caché del navegador (Ctrl+Shift+Del)

### Error 500 al reescribir URLs
- [ ] Verifica que `mod_rewrite` esté habilitado en `httpd.conf` (sin #)
- [ ] Verifica que el `.htaccess` sea exacto (sin espacios o caracteres raros)
- [ ] Verifica que `AllowOverride All` esté en el Virtual Host

### Apache no inicia
- [ ] Abre PowerShell como admin
- [ ] Ejecuta: `C:\xampp\apache\bin\httpd -t`
- [ ] Busca el error específico

### Puerto 80 en uso
Si otro programa usa puerto 80, cambia el Virtual Host:
```apache
<VirtualHost *:8080>
    ...
</VirtualHost>
```

Y accede a `http://gestion-riesgos.local:8080`

---

## Checklist de Producción (Si necesitas subir esto)

- [ ] Cambiar `APP_DEBUG=false` en `.env`
- [ ] Ejecutar `php artisan config:cache`
- [ ] Ejecutar `php artisan route:cache`
- [ ] Usar `mod_ssl` para HTTPS
- [ ] Configurar Firewall
- [ ] Monitorear logs regularmente
- [ ] Usar PHP 8.1 o superior (actuales)

---

## Recursos
- [Laravel Deployment - Apache](https://laravel.com/docs/11.x/deployment#apache)
- [XAMPP Apache Configuration](https://www.apachefriends.org/)
- [PHP Performance Tips](https://www.php.net/manual/en/performance.php)
