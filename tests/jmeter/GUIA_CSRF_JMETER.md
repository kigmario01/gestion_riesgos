# Guía: Configurar CSRF Token en JMeter para Laravel

## Problema
JMeter envía POST requests sin incluir el token CSRF que Laravel exige, resultando en respuestas **419 Pagina Expirada**.

## Solución: 4 Pasos

### Paso 1 — Agregar HTTP Cookie Manager
1. En tu **Thread Group**, clic derecho → **Add** → **Config Element** → **HTTP Cookie Manager**
2. **Déjalo con la configuración por defecto** (acepta cookies automáticamente)
3. Esto emula el comportamiento de un navegador web

✅ **Resultado**: Las cookies de sesión se persisten entre requests

---

### Paso 2 — Agregar Regular Expression Extractor (Para el Token CSRF)

**En el sampler GET /login (o cualquier formulario que cargues):**

1. Clic derecho en el sampler → **Add** → **Post Processors** → **Regular Expression Extractor**
2. Configúralo con estos valores exactos:

| Campo | Valor |
|-------|-------|
| **Name** | Extractor CSRF |
| **Reference Name** | `csrf_token` |
| **Regular Expression** | `<input[^>]*name="_token"[^>]*value="([^"]+)"` |
| **Template** | `$1$` |
| **Match No.** | `1` |
| **Default Value** | `TOKEN_NO_ENCONTRADO` |

✅ **Resultado**: El token se extrae del atributo `value` del campo `_token` 

**Nota**: La regex busca específicamente `name="_token"` (es el nombre por defecto de Laravel)

---

### Paso 3 — Usar el Token en Requests POST

**En cada sampler POST (crear, actualizar, etc.):**

1. Ve a la pestaña **Body Data** o **Parameters**
2. Agrega este campo:

| Name | Value |
|------|-------|
| `_token` | `${csrf_token}` |

3. Si el POST es un **formulario HTML tradicional**, también envía los otros campos del formulario

✅ **Resultado**: El token se incluye automáticamente en cada POST

---

### Paso 4 — Orden Correcto de Samplers

**IMPORTANTE**: El orden en el Thread Group debe ser:

```
1. GET /login          [con el Extractor CSRF]
2. POST /login         [usando ${csrf_token}]
3. GET /activos        [con su propio Extractor CSRF para crear]
4. POST /activos       [usando ${csrf_token}]
5. GET /amenazas       [con su propio Extractor CSRF]
6. POST /amenazas      [usando ${csrf_token}]
... y así sucesivamente
```

**❌ NO HAGAS ESTO**:
- POST antes de GET (el token llegará vacío)
- Reutilizar el mismo token para múltiples formularios (cada formulario tiene su propio token)

---

## Plantilla de Estructura en JMeter

```
Thread Group (Usuarios concurrentes)
├── HTTP Cookie Manager
├── GET /login
│   └── Regular Expression Extractor (csrf_token)
├── POST /login
│   └── Body: _token=${csrf_token}, usuario=..., password=...
├── GET /activos
│   └── Regular Expression Extractor (csrf_token)
├── POST /activos
│   └── Body: _token=${csrf_token}, nombre=..., codigo=...
├── GET /amenazas
│   └── Regular Expression Extractor (csrf_token)
├── POST /amenazas
│   └── Body: _token=${csrf_token}, ...
└── ...
```

---

## Verificar que Funciona

1. **Ejecuta el test con 1 usuario (no concurrencia)**
2. Ve a **View Results Tree**
3. En cada POST, verifica:
   - **Response code**: debe ser `302` o `200`, NO `419`
   - **Response headers**: si ves `419 Page Expired`, el token no se envió correctamente
   - **Request body**: incluye `_token=eyJ...` (un valor largo)

4. Si ves `419`, revisa:
   - ¿El regex extrae el token? (ve a **View Results Tree** del extractor)
   - ¿El token se pasa como `_token` en el POST? (no como otro nombre)
   - ¿El GET viene antes del POST?

---

## Troubleshooting

### Error 419 persiste
- [ ] Verifica que `HTTP Cookie Manager` esté en el Thread Group
- [ ] Verifica que el `Regular Expression Extractor` esté en el GET (no en el POST)
- [ ] Verifica que la regex `<input[^>]*name="_token"[^>]*value="([^"]+)"` sea exacta
- [ ] Ve a **Debug Sampler** y verifica que `${csrf_token}` contenga un valor (no esté vacío)

### Regex no extrae nada (Default Value aparece)
- [ ] Abre el formulario en el navegador (F12 → Inspector)
- [ ] Busca `<input` y verifica el exacto `name` del campo
- [ ] Es posible que sea `name="csrf_token"` o `name="token"` (adapta la regex)
- [ ] Copia el HTML exacto y prueba la regex en [regex101.com](https://regex101.com)

### Token no se pasa al POST
- [ ] En el sampler POST, verifica que el campo se llame exactamente `_token` (sensible a mayúsculas)
- [ ] En el **Body**, debe estar: `_token=${csrf_token}`
- [ ] No uses `${CSRF_TOKEN}` o `$csrf_token` (tiene que ser exacto el nombre de la variable)

---

## Ejemplo Completo: Test de Crear Activo

```
GET /dashboard
  └── Status OK 200

GET /activos/create
  └── Regular Expression Extractor: csrf_token = extraído del HTML
  └── Status OK 200

POST /activos
  └── Body:
      _token=${csrf_token}
      nombre=Servidor Web Production
      codigo=SRV-001
      tipo=hardware
      criticidad=critica
      estado=activo
  └── Status 302 Redirect o 200
  └── ❌ NO debe ser 419
```

---

## Para Pruebas Bajo Concurrencia

Si usas **5, 10 o 100 usuarios simultáneos**:

1. Cada usuario tiene su **propia sesión** (la cookie los separa)
2. Cada usuario debe tener su **propio token** (el extractor los captura por sesión)
3. **JMeter maneja esto automáticamente** si todo está bien configurado

✅ Resultado esperado: tasa de error < 2%, tiempos máximos < 2000 ms

---

## Recursos
- [Laravel CSRF Protection Docs](https://laravel.com/docs/11.x/csrf)
- [JMeter Regular Expression Extractor](https://jmeter.apache.org/usermanual/component_reference.html#Regular_Expression_Extractor)
- [OWASP - CSRF Prevention](https://owasp.org/www-community/attacks/csrf)
