# Plan Completo: Reducir Errores 419 y 500 en JMeter (Laravel)

## Resumen de Problemas y Soluciones

| Problema | Causa | Solución |
|----------|-------|----------|
| **Error 419 Pagina Expirada** | Token CSRF no se envía en POST | Configurar Regular Expression Extractor en JMeter |
| **Error 500 bajo concurrencia** | `php artisan serve` es single-threaded | Cambiar a Apache (multi-threaded) |
| **Requests lentos (5000+ ms)** | Queries N+1 a la BD | Optimizar Controllers con `with()` y `prefetch_related()` |

---

## Orden de Implementación (Recomendado)

### Fase 1: Optimizar Base de Datos (30 minutos)

✅ **YA COMPLETADO EN CÓDIGO**

Se han optimizado:
- `DashboardController` → 10 queries → 5-6 queries
- `EvaluacionRiesgoController` → Añadida paginación
- `ActivoTiController` → Ya estaba optimizado
- `AmenazaController` → Ya estaba optimizado
- `PlanMitigacionController` → Ya estaba optimizado

**Cambios aplicados**:
```php
// ANTES: 4 queries separadas
$totalCritico = EvaluacionRiesgo::where('nivel_riesgo', 'critico')->count();
$totalAlto = EvaluacionRiesgo::where('nivel_riesgo', 'alto')->count();
// ...

// DESPUÉS: 1 query con groupBy
$riesgosNivel = EvaluacionRiesgo::where('estado', 'activa')
    ->groupBy('nivel_riesgo')
    ->selectRaw('nivel_riesgo, COUNT(*) as total')
    ->pluck('total', 'nivel_riesgo');
```

---

### Fase 2: Configurar CSRF en JMeter (20 minutos)

📄 **GUÍA**: Ver `GUIA_CSRF_JMETER.md`

**Pasos resumidos**:

1. **HTTP Cookie Manager** en el Thread Group
2. **Regular Expression Extractor** en cada GET que carga formulario
   - Reference Name: `csrf_token`
   - Regex: `<input[^>]*name="_token"[^>]*value="([^"]+)"`
3. **Agregar `_token=${csrf_token}`** a cada POST

**Ejemplo mínimo**:
```
Thread Group
├── HTTP Cookie Manager
├── GET /login
│   └── Regular Expression Extractor (csrf_token)
├── POST /login [Body: _token=${csrf_token}, usuario=..., pass=...]
├── GET /activos [si necesitas crear]
│   └── Regular Expression Extractor (csrf_token)
└── POST /activos [Body: _token=${csrf_token}, nombre=..., ...]
```

**Verificar**: Ejecuta con 1 usuario. En View Results Tree, los POST deben dar 302 o 200, **nunca 419**.

---

### Fase 3: Cambiar Servidor a Apache (15 minutos)

📄 **GUÍA**: Ver `GUIA_SERVIDOR_APACHE.md`

**Pasos resumidos**:

1. Agregar Virtual Host en `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
2. Agregar entrada en `C:\Windows\System32\drivers\etc\hosts` → `127.0.0.1  gestion-riesgos.local`
3. Descomentar `mod_rewrite` en `httpd.conf`
4. Crear `.htaccess` en `public/`
5. Reiniciar Apache

**Acceso**: `http://gestion-riesgos.local` (o `http://localhost`)

**Verificar**: Abre `http://gestion-riesgos.local/dashboard` en el navegador y asegúrate de que funcione.

---

### Fase 4: Pruebas de Carga en JMeter

**Parámetros de prueba**:

1. **Prueba 1: Sin concurrencia** (1 usuario, 1 iteración)
   - Objetivo: Verificar que no hay errores 419 ni 500
   - Resultado esperado: 100% success

2. **Prueba 2: Concurrencia baja** (5 usuarios, 10 iteraciones)
   - Objetivo: Verificar comportamiento bajo carga ligera
   - Resultado esperado: 98%+ success, times < 1000 ms

3. **Prueba 3: Concurrencia media** (20 usuarios, 5 iteraciones)
   - Objetivo: Verificar estabilidad
   - Resultado esperado: 95%+ success, times < 2000 ms

4. **Prueba 4: Concurrencia alta** (50+ usuarios, 3 iteraciones)
   - Objetivo: Encontrar límites
   - Resultado esperado: 90%+ success, times < 3000 ms

---

## Checklist Rápido

Ejecuta esto **EN ORDEN**:

- [ ] **Paso 1: Verificar optimizaciones en código**
  ```powershell
  # Ve a app/Http/Controllers/ y verifica que DashboardController tenga groupBy
  ```

- [ ] **Paso 2: Configurar CSRF en JMeter**
  - [ ] HTTP Cookie Manager ✓
  - [ ] Regular Expression Extractor en GET /login ✓
  - [ ] `_token=${csrf_token}` en POST /login ✓
  - [ ] Mismo patrón en otros formularios ✓

- [ ] **Paso 3: Cambiar a Apache**
  - [ ] Virtual Host creado ✓
  - [ ] Hosts file actualizado ✓
  - [ ] Apache reiniciado ✓
  - [ ] `http://gestion-riesgos.local` accesible ✓

- [ ] **Paso 4: Actualizar URLs en JMeter**
  - [ ] Cambiar `127.0.0.1:8000` → `gestion-riesgos.local` ✓

- [ ] **Paso 5: Ejecutar Prueba 1 (sin concurrencia)**
  - [ ] Error rate: 0% ✓
  - [ ] No hay 419 ni 500 ✓

- [ ] **Paso 6: Ejecutar Prueba 2-4 (con concurrencia)**
  - [ ] Error rate < 2% ✓
  - [ ] Tiempos máximos < 2000 ms ✓

---

## Resultados Esperados

**Antes de optimizaciones:**
- Tasa de error: 10-20% (419, 500)
- Tiempo máximo: 5000+ ms
- Response time promedio: 1500+ ms

**Después de optimizaciones (Fase 1-3):**
- Tasa de error: < 2%
- Tiempo máximo: < 2000 ms
- Response time promedio: < 500 ms

**Bajo concurrencia (50+ usuarios):**
- Tasa de error: < 5% (picos ocasionales)
- Tiempo máximo: < 3000 ms
- Response time promedio: < 1000 ms

---

## Troubleshooting Rápido

### Todavía hay errores 419
1. ¿Agregaste `HTTP Cookie Manager`? → Agrégalo
2. ¿El Extractor está en el GET (antes del POST)? → Muévelo
3. ¿Pasas `_token=${csrf_token}` en el POST? → Verifica en View Results Tree
4. ¿El valor de `${csrf_token}` es largo (eyJ...)? → Si no, la regex está mal

### Apache no inicia
1. Abre **XAMPP Control Panel**
2. Haz clic en **Config** (Apache) → **httpd.conf**
3. Busca errores de sintaxis
4. Ejecuta en PowerShell: `C:\xampp\apache\bin\httpd -t`

### JMeter todavía lento bajo concurrencia
1. Verifica que Apache esté corriendo (XAMPP Control Panel)
2. Ve a `http://localhost/dashboard` y verifica respuesta rápida
3. Revisa los logs: `C:\xampp\apache\logs\error.log`
4. Considera aumentar `MaxRequestWorkers` en Apache config

---

## Archivos Generados

Los siguientes archivos han sido creados para referencia:

1. **GUIA_CSRF_JMETER.md** → Instrucciones detalladas para CSRF
2. **GUIA_SERVIDOR_APACHE.md** → Instrucciones detalladas para Apache
3. Este archivo → Plan completo

---

## Siguiente Pasos (Si necesitas más optimización)

Si después de completar todo aún tienes problemas:

1. **Caching**: Implementar Redis para sessiones y caché
2. **CDN**: Servir assets estáticos desde CDN
3. **Database Indexing**: Crear índices en tablas de búsqueda frecuente
4. **Async Jobs**: Mover tareas pesadas a queues (Laravel Jobs)
5. **Monitoreo**: Usar Laravel Debugbar o New Relic para profiling

---

## Contacto / Preguntas

Si algo no funciona después de seguir esto, verifica:
- [ ] Archivo `.htaccess` (sin BOM, sin espacios raros)
- [ ] Permisos en carpeta `/storage`
- [ ] Variable `APP_DEBUG` en `.env` (puede ser `true` para ver errores)
- [ ] Logs en `storage/logs/laravel.log`

---

**Versión**: 1.0  
**Fecha**: Abril 27, 2026  
**Aplicación**: Gestión de Riesgos (Laravel)
