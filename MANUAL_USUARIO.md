# MANUAL DE USUARIO
## RiskGuard TI — Sistema de Gestión de Riesgos de Información
### Versión 1.0 · Mayo 2026

---

**Sistema:** RiskGuard TI  
**Versión:** 1.0  
**Fecha:** Mayo 2026  
**Dirigido a:** Usuarios finales del sistema (gestores de riesgo, auditores, administradores)  
**URL de acceso:** https://gestion-riesgos-7d9n.onrender.com  

---

## TABLA DE CONTENIDOS

1. [Introducción](#1-introducción)
2. [Acceso al Sistema](#2-acceso-al-sistema)
3. [Interfaz Principal](#3-interfaz-principal)
4. [Dashboard](#4-dashboard)
5. [Activos TI](#5-activos-ti)
6. [Amenazas](#6-amenazas)
7. [Evaluaciones de Riesgo](#7-evaluaciones-de-riesgo)
8. [Planes de Mitigación](#8-planes-de-mitigación)
9. [Matriz de Riesgos](#9-matriz-de-riesgos)
10. [Bitácora de Auditoría](#10-bitácora-de-auditoría)
11. [Reportes PDF](#11-reportes-pdf)
12. [Gestión de Usuarios](#12-gestión-de-usuarios)
13. [Roles y Permisos](#13-roles-y-permisos)
14. [Respaldo de Base de Datos](#14-respaldo-de-base-de-datos)
15. [Mi Perfil](#15-mi-perfil)
16. [Preguntas Frecuentes](#16-preguntas-frecuentes)

---

## 1. INTRODUCCIÓN

### 1.1 ¿Qué es RiskGuard TI?

**RiskGuard TI** es un sistema web para la gestión de riesgos de seguridad de la información, alineado al estándar internacional **ISO/IEC 27001:2022**. Permite a las organizaciones identificar sus activos tecnológicos, evaluar las amenazas que los afectan, calcular el nivel de riesgo y planificar acciones de mitigación.

### 1.2 ¿Para qué sirve?

Con RiskGuard TI usted puede:

- Llevar un **inventario** de todos los activos tecnológicos de su organización
- Registrar y catalogar **amenazas** de seguridad
- **Calcular el nivel de riesgo** de cada activo frente a cada amenaza
- Crear y hacer seguimiento a **planes de mitigación**
- Ver el panorama completo de riesgos en una **matriz visual**
- Generar **reportes PDF** para presentar a directivos o auditores
- Mantener una **bitácora** de todas las acciones realizadas en el sistema

### 1.3 Requisitos para usar el sistema

- Navegador web moderno: Chrome, Firefox, Edge o Safari (versión reciente)
- Conexión a Internet
- Cuenta de usuario activa (creada por el administrador)

---

## 2. ACCESO AL SISTEMA

### 2.1 Iniciar sesión

1. Abra su navegador y vaya a la dirección del sistema
2. En la pantalla de inicio de sesión ingrese:
   - **Correo electrónico:** su email registrado
   - **Contraseña:** su contraseña
3. Haga clic en **"Iniciar sesión"**

![Pantalla de login con campo email y contraseña]

> **Nota:** Si ingresa mal la contraseña 5 veces seguidas, el sistema bloqueará temporalmente el acceso desde su dispositivo como medida de seguridad.

### 2.2 Cuenta desactivada

Si al intentar ingresar aparece el mensaje:

> *"Tu cuenta está desactivada. Comunícate con el administrador para reactivarla."*

Significa que su cuenta fue desactivada por un administrador. Contacte al administrador del sistema para solicitar la reactivación.

**Contacto del administrador:** mario.alvarezr@campusucc.edu.co

### 2.3 Cerrar sesión

Para cerrar sesión de forma segura:

1. En la parte inferior del menú lateral, haga clic en **"Cerrar sesión"** (ícono de salida, fondo rojo)

> **Importante:** Siempre cierre sesión cuando termine de usar el sistema, especialmente en computadores compartidos.

---

## 3. INTERFAZ PRINCIPAL

### 3.1 Estructura de la pantalla

La interfaz está dividida en tres zonas:

```
┌─────────────────────────────────────────────────────┐
│                   BARRA SUPERIOR                     │
│  [Ícono + Título de la sección]    [Botones acción]  │
├──────────────┬──────────────────────────────────────┤
│              │                                       │
│   MENÚ       │         ÁREA DE CONTENIDO             │
│  LATERAL     │                                       │
│  (sidebar)   │   Aquí se muestra la información      │
│              │   de cada módulo                      │
│              │                                       │
│  [Usuario]   │                                       │
│  [Cerrar     │                                       │
│   sesión]    │                                       │
└──────────────┴──────────────────────────────────────┘
```

### 3.2 Menú lateral (sidebar)

El menú lateral contiene todos los módulos del sistema, organizados en secciones:

| Sección | Módulos |
|---------|---------|
| **PRINCIPAL** | Dashboard, Matriz de Riesgos |
| **GESTIÓN** | Activos TI, Amenazas, Evaluaciones, Cálculo de Riesgo, Mitigación |
| **AUDITORÍA** | Bitácora, Reportes PDF |
| **ADMINISTRACIÓN** | Usuarios, Roles |
| **SISTEMA** | Respaldo de BD |

> **Nota:** Solo verá en el menú los módulos a los que tiene acceso según su rol.

### 3.3 Modo oscuro

El sistema tiene dos temas visuales: **claro** y **oscuro**.

Para cambiar el tema:
- Haga clic en el ícono de luna/sol ubicado en la parte inferior del menú lateral

El tema elegido se guarda automáticamente en su navegador.

### 3.4 Perfil de usuario (sidebar)

En la parte inferior del menú lateral verá:
- Su **foto de perfil** (o sus iniciales si no tiene foto)
- Su **nombre** (o alias si configuró uno)
- Su **rol** en el sistema
- Un ícono de lápiz para ir directamente a editar su perfil

---

## 4. DASHBOARD

El **Dashboard** es la pantalla principal que ve al ingresar al sistema. Ofrece un resumen ejecutivo del estado de riesgos.

### 4.1 Contadores de resumen

En la parte superior encontrará tarjetas con los indicadores principales:

| Indicador | Descripción |
|-----------|-------------|
| **Activos TI** | Total de activos registrados |
| **Amenazas activas** | Total de amenazas en el catálogo |
| **Evaluaciones** | Total de evaluaciones realizadas |
| **Planes pendientes** | Planes de mitigación sin completar |

### 4.2 Últimos riesgos activos

Tabla con los riesgos más recientes, mostrando:
- Activo afectado
- Amenaza identificada
- Nivel de riesgo (con color indicativo)
- Usuario que realizó la evaluación

### 4.3 Actividad reciente

Listado de las últimas acciones registradas en el sistema (bitácora resumida).

---

## 5. ACTIVOS TI

Los **activos TI** son todos los recursos tecnológicos que tienen valor para la organización: servidores, computadores, software, bases de datos, redes, etc.

### 5.1 Ver la lista de activos

1. En el menú lateral, haga clic en **"Activos TI"**
2. Verá la tabla con todos los activos registrados
3. Puede buscar o filtrar usando los controles disponibles

**Columnas de la tabla:**

| Columna | Descripción |
|---------|-------------|
| Nombre | Nombre del activo |
| Tipo | Categoría del activo |
| Criticidad | Nivel de importancia (Bajo/Medio/Alto/Crítico) |
| Estado | Estado operativo actual |
| Propietario | Responsable del activo |
| Acciones | Botones para ver, editar o eliminar |

### 5.2 Crear un nuevo activo

1. Haga clic en el botón **"+ Nuevo Activo"** (esquina superior derecha)
2. Complete el formulario:

| Campo | Obligatorio | Descripción |
|-------|-------------|-------------|
| **Nombre** | Sí | Nombre descriptivo del activo |
| **Tipo** | Sí | Servidor / Red / Software / Base de datos / Endpoint / Otro |
| **Descripción** | No | Detalles adicionales |
| **Propietario** | Sí | Persona o área responsable |
| **Ubicación** | No | Dónde se encuentra (física o lógicamente) |
| **Criticidad** | Sí | Qué tan crítico es para la organización |
| **Estado** | Sí | Activo / En mantenimiento / Dado de baja |
| **Valor económico** | No | Estimación del valor en dinero |
| **Fecha de adquisición** | No | Cuándo fue incorporado |

3. Haga clic en **"Guardar"**

> **Guía ISO 27001:** Cada activo debe clasificarse según su criticidad para priorizar los controles de seguridad (Control A.8 — Gestión de activos).

### 5.3 Ver el detalle de un activo

1. En la lista, haga clic en el ícono de ojo **👁** del activo
2. Verá toda la información del activo y las evaluaciones de riesgo asociadas

### 5.4 Editar un activo

1. En la lista o en el detalle, haga clic en el ícono de lápiz **✏**
2. Modifique los campos necesarios
3. Haga clic en **"Guardar cambios"**

### 5.5 Eliminar un activo

1. En la lista, haga clic en el ícono de papelera **🗑**
2. Confirme la eliminación en el diálogo que aparece

> **Advertencia:** Eliminar un activo eliminará también todas sus evaluaciones de riesgo asociadas. Esta acción no se puede deshacer.

---

## 6. AMENAZAS

Las **amenazas** son situaciones o eventos que podrían causar daño a los activos de la organización (ataques, fallos, desastres, errores humanos, etc.).

### 6.1 Ver el catálogo de amenazas

1. En el menú lateral, haga clic en **"Amenazas"**
2. Verá el catálogo completo de amenazas registradas

El sistema incluye amenazas predefinidas basadas en el estándar ISO/IEC 27005. Puede agregar amenazas específicas de su organización.

### 6.2 Crear una nueva amenaza

1. Haga clic en **"+ Nueva Amenaza"**
2. Complete el formulario:

| Campo | Obligatorio | Descripción |
|-------|-------------|-------------|
| **Nombre** | Sí | Nombre de la amenaza |
| **Categoría** | Sí | Técnica / Humana / Ambiental / Organizacional |
| **Descripción** | No | Explicación detallada |
| **Probabilidad** | Sí | Qué tan probable es que ocurra |
| **Impacto** | Sí | Qué tan grave sería si ocurre |
| **Origen** | Sí | Interno / Externo / Ambos |

**Escala de probabilidad:**

| Valor | Descripción |
|-------|-------------|
| Rara | Ocurre solo en circunstancias excepcionales |
| Improbable | Podría ocurrir en algún momento |
| Posible | Podría ocurrir en algún momento del año |
| Probable | Probablemente ocurrirá |
| Casi Segura | Se espera que ocurra |

**Escala de impacto:**

| Valor | Descripción |
|-------|-------------|
| Insignificante | Sin consecuencias relevantes |
| Menor | Consecuencias menores, fácilmente recuperables |
| Moderado | Consecuencias significativas, recuperación posible |
| Mayor | Consecuencias graves, recuperación difícil |
| Catastrófico | Consecuencias devastadoras para la organización |

### 6.3 Editar o eliminar una amenaza

Utilice los botones de acción en la tabla (lápiz para editar, papelera para eliminar).

---

## 7. EVALUACIONES DE RIESGO

Las **evaluaciones de riesgo** vinculan un activo con una amenaza y calculan el nivel de riesgo resultante.

### 7.1 Ver las evaluaciones

1. En el menú lateral, haga clic en **"Evaluaciones"** o **"Cálculo de Riesgo"**
2. Verá la lista de todas las evaluaciones realizadas con su nivel de riesgo

**Colores del nivel de riesgo:**

| Color | Nivel | Valor | Acción recomendada |
|-------|-------|-------|-------------------|
| 🟢 Verde | Bajo | 1–4 | Monitoreo periódico |
| 🟡 Amarillo | Medio | 5–9 | Plan de mejora |
| 🟠 Naranja | Alto | 10–14 | Acción prioritaria |
| 🔴 Rojo | Crítico | 15–25 | Acción inmediata |

### 7.2 Crear una evaluación de riesgo

1. Haga clic en **"+ Nueva Evaluación"**
2. Complete el formulario:

| Campo | Obligatorio | Descripción |
|-------|-------------|-------------|
| **Activo TI** | Sí | Seleccione el activo a evaluar |
| **Amenaza** | Sí | Seleccione la amenaza a considerar |
| **Probabilidad** | Sí | Del 1 (muy baja) al 5 (muy alta) |
| **Impacto** | Sí | Del 1 (mínimo) al 5 (catastrófico) |
| **Fecha de evaluación** | Sí | Fecha en que se realiza la evaluación |
| **Observaciones** | No | Notas o justificación de los valores |

3. El sistema calculará automáticamente:
   - **Nivel de riesgo** = Probabilidad × Impacto
   - **Clasificación** = Bajo / Medio / Alto / Crítico

4. Haga clic en **"Guardar evaluación"**

> **Ejemplo:** Un servidor de base de datos (activo) con probabilidad 4 de sufrir un ataque de ransomware (amenaza) y un impacto de 5 da un nivel de riesgo de **20 → Crítico**.

### 7.3 Ver el detalle de una evaluación

Haga clic en el ícono de ojo para ver:
- Datos completos de la evaluación
- Activo y amenaza involucrados
- Nivel y clasificación del riesgo
- Historial de cambios
- Planes de mitigación asociados

### 7.4 Cambiar el estado de una evaluación

Los estados posibles son:
- **Activo:** Riesgo identificado, pendiente de tratamiento
- **En tratamiento:** Tiene un plan de mitigación activo
- **Tratado:** El riesgo fue reducido a un nivel aceptable
- **Aceptado:** La organización decidió aceptar el riesgo

---

## 8. PLANES DE MITIGACIÓN

Los **planes de mitigación** son las acciones que la organización tomará para tratar los riesgos identificados.

### 8.1 Ver los planes

1. En el menú lateral, haga clic en **"Mitigación"**
2. Verá todos los planes con su estado actual

### 8.2 Tipos de tratamiento de riesgo

| Tipo | Descripción | Cuándo usar |
|------|-------------|-------------|
| **Reducir** | Implementar controles para disminuir el riesgo | Riesgo Alto o Crítico |
| **Aceptar** | Reconocer el riesgo sin tomar acción | Riesgo Bajo o cuando el costo supera el beneficio |
| **Transferir** | Pasar el riesgo a un tercero (seguro, outsourcing) | Cuando no se puede controlar internamente |
| **Evitar** | Eliminar la actividad que genera el riesgo | Cuando el riesgo es inaceptable |

### 8.3 Crear un plan de mitigación

1. Haga clic en **"+ Nuevo Plan"**
2. Complete el formulario:

| Campo | Obligatorio | Descripción |
|-------|-------------|-------------|
| **Evaluación de riesgo** | Sí | Seleccione el riesgo que va a tratar |
| **Título** | Sí | Nombre descriptivo del plan |
| **Descripción** | Sí | Detalle de las acciones a realizar |
| **Tipo de tratamiento** | Sí | Reducir / Aceptar / Transferir / Evitar |
| **Responsable** | Sí | Persona que ejecutará el plan |
| **Fecha de inicio** | Sí | Cuándo comenzará la implementación |
| **Fecha de fin** | Sí | Fecha límite para completar |
| **Costo estimado** | No | Presupuesto requerido |
| **Controles ISO** | No | Controles del Anexo A de ISO 27001 aplicables |

3. Haga clic en **"Guardar plan"**

### 8.4 Flujo de aprobación

Los planes deben ser aprobados por un usuario con permiso `mitigacion.aprobar`:

```
CREADO → EN PROCESO → (aprobación) → COMPLETADO
                   → (rechazo)    → CANCELADO
```

Para aprobar un plan:
1. Abra el detalle del plan
2. Haga clic en el botón **"Aprobar plan"**
3. Confirme la aprobación

### 8.5 Estados del plan

| Estado | Significado |
|--------|-------------|
| **Pendiente** | Creado, esperando inicio |
| **En Proceso** | En implementación |
| **Completado** | Acciones ejecutadas exitosamente |
| **Cancelado** | Plan descartado |

---

## 9. MATRIZ DE RIESGOS

La **Matriz de Riesgos** es una representación visual del mapa de riesgos de la organización.

### 9.1 Cómo leer la matriz

1. En el menú lateral, haga clic en **"Matriz de Riesgos"**
2. Verá una cuadrícula de 5×5 donde:
   - El **eje vertical** representa la **Probabilidad** (1=baja, 5=alta)
   - El **eje horizontal** representa el **Impacto** (1=mínimo, 5=catastrófico)
   - Cada **celda** contiene los activos que tienen ese nivel de riesgo
   - El **color** indica la clasificación (verde/amarillo/naranja/rojo)

### 9.2 Interpretación

- Las celdas en la esquina **superior derecha** (rojo) son los riesgos más críticos y requieren atención inmediata
- Las celdas en la esquina **inferior izquierda** (verde) son riesgos bajos que pueden monitorearse periódicamente
- Haga clic en un activo dentro de la matriz para ver su evaluación completa

---

## 10. BITÁCORA DE AUDITORÍA

La **Bitácora** registra automáticamente todas las acciones realizadas en el sistema. Es el registro de auditoría del SGSI.

### 10.1 Ver la bitácora

1. En el menú lateral, haga clic en **"Bitácora"**
2. Verá el listado cronológico de todas las acciones

**Información registrada en cada entrada:**

| Campo | Descripción |
|-------|-------------|
| Fecha y hora | Cuándo ocurrió la acción (hora Colombia) |
| Usuario | Quién realizó la acción |
| Módulo | Qué parte del sistema fue afectada |
| Acción | Qué se hizo (crear, editar, eliminar, exportar, etc.) |
| Descripción | Detalle de lo que cambió |

### 10.2 Usos principales

- **Auditorías internas:** Verificar que los procesos se ejecuten correctamente
- **Investigación de incidentes:** Rastrear qué cambios se hicieron y cuándo
- **Cumplimiento ISO 27001:** Evidencia de control A.12.4.1 (Registro de eventos)

> **Nota:** La bitácora es de **solo lectura**. Ningún usuario puede modificar o eliminar entradas de la bitácora.

---

## 11. REPORTES PDF

El sistema puede generar reportes formales en formato PDF para presentar a directivos, auditores u otras partes interesadas.

### 11.1 Tipos de reportes disponibles

| Reporte | Contenido | Audiencia |
|---------|-----------|-----------|
| **Ejecutivo** | Resumen gerencial del estado de riesgos | Dirección, Gerencia |
| **Activos TI** | Inventario completo de activos | Área TI, Auditoría |
| **Amenazas** | Catálogo de amenazas identificadas | Gestores de riesgo |
| **Evaluaciones** | Detalle de todas las evaluaciones | Analistas, Auditores |
| **Mitigación** | Estado de planes de tratamiento | Gestores, Dirección |
| **Bitácora** | Registro completo de actividades | Auditores internos/externos |

### 11.2 Generar un reporte

1. En el menú lateral, haga clic en **"Reportes PDF"** para expandir el submenú
2. Seleccione el tipo de reporte que desea generar
3. El reporte se descargará automáticamente en formato PDF

> **Nota:** La generación del reporte puede tardar unos segundos dependiendo de la cantidad de datos.

---

## 12. GESTIÓN DE USUARIOS

Esta sección está disponible solo para usuarios con rol **Administrador** o permisos de gestión de usuarios.

### 12.1 Ver la lista de usuarios

1. En el menú lateral (sección Administración), haga clic en **"Usuarios"**
2. Verá la tabla con todos los usuarios del sistema:

| Columna | Descripción |
|---------|-------------|
| Usuario | Foto/iniciales + nombre completo |
| Email | Correo electrónico |
| Rol | Rol(es) asignados |
| Estado | ACTIVO / INACTIVO |
| Último acceso | Cuándo ingresó por última vez |
| Registro | Fecha de creación de la cuenta |

### 12.2 Crear un nuevo usuario

1. Haga clic en **"+ Nuevo Usuario"**
2. Complete el formulario con:
   - Nombre completo
   - Correo electrónico
   - Contraseña temporal
   - Rol(es) a asignar
3. Haga clic en **"Guardar"**
4. Comunique al nuevo usuario sus credenciales de acceso

### 12.3 Editar un usuario

1. En la lista, haga clic en el ícono de lápiz **✏**
2. Puede modificar nombre, email, contraseña y roles
3. Guarde los cambios

### 12.4 Activar o desactivar un usuario

Para suspender temporalmente el acceso de un usuario sin eliminarlo:

1. En la lista de usuarios, haga clic en el botón de estado (ícono de prohibición para desactivar, de check para activar)
2. La acción se aplica inmediatamente

**Efecto de desactivar un usuario:**
- Si intenta iniciar sesión: verá el mensaje de cuenta desactivada
- Si tiene sesión activa: será desconectado automáticamente en su próxima acción
- Sus datos e historial se conservan intactos

> **Casos de uso:** Baja temporal de empleado, sospecha de acceso no autorizado, cuenta comprometida.

### 12.5 Eliminar un usuario

1. En la lista, haga clic en el ícono de papelera **🗑**
2. Confirme la eliminación

> **Advertencia:** La eliminación de un usuario es permanente. Considere desactivarlo en lugar de eliminarlo para conservar el historial de auditoría.

### 12.6 Ver el perfil de un usuario

Haga clic en el ícono de ojo **👁** para ver:
- Información completa del usuario
- Roles y permisos asignados
- Historial de acceso

---

## 13. ROLES Y PERMISOS

Los **roles** determinan qué puede hacer cada usuario en el sistema.

### 13.1 Ver los roles

1. En el menú lateral (sección Administración), haga clic en **"Roles"**
2. Verá la lista de roles disponibles con el número de usuarios y permisos de cada uno

### 13.2 Roles predefinidos del sistema

| Rol | Acceso principal |
|-----|-----------------|
| **admin** | Acceso total a todas las funcionalidades |
| **gestor_riesgos** | Gestión completa de activos, amenazas, evaluaciones y mitigación |
| **auditor** | Solo lectura en todos los módulos + bitácora + reportes |
| **backend** | Administración técnica del sistema |
| **frontend** | Acceso limitado a vistas de consulta |
| **base_datos** | Gestión de respaldos de base de datos |
| **scrum_master** | Coordinación general del proyecto |

### 13.3 Editar los permisos de un rol

1. En la lista de roles, haga clic en el ícono de lápiz **✏**
2. Verá todos los permisos organizados por módulo
3. Active o desactive los permisos haciendo clic en cada tarjeta:
   - **Tarjeta naranja con ✓:** permiso activado
   - **Tarjeta gris sin ✓:** permiso desactivado
4. Use **"Seleccionar módulo"** para activar todos los permisos de un módulo de una vez
5. Use **"Seleccionar todos"** para activar todos los permisos del rol
6. Haga clic en **"Guardar Cambios"**

> **Advertencia:** Los cambios de permisos afectan inmediatamente a todos los usuarios con ese rol.

### 13.4 Ver los permisos de un rol

Haga clic en el ícono de ojo **👁** para ver el detalle del rol y la lista de permisos activos.

---

## 14. RESPALDO DE BASE DE DATOS

Esta sección está disponible para usuarios con permisos de administración de base de datos.

### 14.1 Ver el historial de respaldos

1. En el menú lateral (sección Sistema), haga clic en **"Respaldo BD"**
2. Verá:
   - Estadísticas (total de respaldos, exitosos, fecha del último)
   - Tabla con el historial de respaldos

### 14.2 Generar un respaldo manual

1. Haga clic en el botón **"Generar Respaldo"** (esquina superior derecha)
2. Confirme la operación
3. El sistema generará un archivo `.sql` con toda la base de datos
4. El respaldo aparecerá en el historial con estado **EXITOSO** o **FALLIDO**

### 14.3 Descargar un respaldo

1. En el historial, ubique el respaldo que desea descargar
2. Haga clic en el ícono de descarga **⬇**
3. El archivo `.sql` se descargará a su computador

> **Guarda los respaldos descargados en un lugar seguro y externo al servidor.**

### 14.4 Configurar respaldo automático

El sistema puede generar respaldos de forma automática en el horario que configure:

1. En la página de Respaldo BD, busque el panel **"Respaldo Automático"**
2. Configure las opciones:

| Opción | Descripción |
|--------|-------------|
| **Estado** | Activar o desactivar el respaldo automático |
| **Frecuencia** | Diario / Semanal / Mensual |
| **Hora** | La hora exacta a la que se ejecutará (formato 24h) |
| **Día de semana** | Solo para frecuencia Semanal (Lunes a Domingo) |
| **Día del mes** | Solo para frecuencia Mensual (1 al 28) |

3. Haga clic en **"Guardar configuración"**

**Ejemplos de configuración:**

| Necesidad | Configuración |
|-----------|--------------|
| Respaldo diario a las 2 AM | Frecuencia: Diario, Hora: 02:00 |
| Respaldo cada lunes a medianoche | Frecuencia: Semanal, Día: Lunes, Hora: 00:00 |
| Respaldo el día 1 de cada mes | Frecuencia: Mensual, Día del mes: 1, Hora: 03:00 |

### 14.5 Eliminar un respaldo

1. En el historial, haga clic en el ícono de papelera del respaldo
2. Confirme la eliminación

> **Nota:** En la plataforma Render los archivos de respaldo se pierden cuando el servidor se reinicia. Descargue siempre los respaldos importantes a su equipo local.

---

## 15. MI PERFIL

Cada usuario puede personalizar su información de presentación en el sistema.

### 15.1 Acceder al perfil

Existen dos formas:
- Haga clic en el ícono de lápiz **✏** junto a su nombre en el menú lateral
- O navegue directamente a la sección de perfil

### 15.2 Cambiar el alias (nombre de visualización)

El **alias** es el nombre que aparecerá en el sistema en lugar de su nombre completo:

1. En el campo **"Alias"**, escriba el nombre que desea mostrar (máximo 50 caracteres)
   - Ejemplos: "Mario A.", "Jefe TI", "MKD", "Auditor Principal"
2. Si deja el campo vacío, se usará su nombre completo
3. Haga clic en **"Guardar cambios"**

### 15.3 Subir una foto de perfil

1. Haga clic en el botón **"Cambiar foto"** (ícono de cámara)
2. Seleccione una imagen de su computador:
   - Formatos aceptados: JPG, PNG o WebP
   - Tamaño máximo: 2 MB
3. Verá una **vista previa** inmediata de cómo quedará la foto
4. Haga clic en **"Guardar cambios"** para confirmar

> **Tip:** Use una foto cuadrada para que se vea bien en el círculo del perfil.

### 15.4 Quitar la foto de perfil

1. Marque la casilla **"Quitar foto"** (aparece solo si tiene foto)
2. Haga clic en **"Guardar cambios"**
3. Se mostrará nuevamente su inicial en el avatar

### 15.5 Información de solo lectura

En la sección de información de cuenta puede ver (pero no editar directamente):
- Nombre completo
- Correo electrónico
- Rol asignado
- Fecha y hora del último acceso

> Para cambiar el nombre, email o contraseña, contacte al administrador del sistema.

---

## 16. PREGUNTAS FRECUENTES

### ¿Qué hago si olvidé mi contraseña?

Contacte al administrador del sistema para que le restablezca la contraseña:
**mario.alvarezr@campusucc.edu.co**

---

### ¿Por qué no veo algunos módulos en el menú?

El acceso a los módulos depende de su **rol** en el sistema. Si necesita acceso a un módulo específico, solicítelo al administrador para que ajuste sus permisos.

---

### ¿Por qué me desconectaron automáticamente?

Puede ser por dos razones:
1. **Su cuenta fue desactivada** por un administrador mientras tenía sesión activa
2. **La sesión expiró** por inactividad

En el primer caso verá el mensaje de cuenta desactivada al intentar reconectarse.

---

### ¿Puedo deshacer una acción?

La mayoría de las acciones de **eliminación** son irreversibles. Para modificaciones (editar), siempre puede volver a editar el registro. Para mayor seguridad, el sistema registra en la bitácora el estado anterior de cada registro modificado.

---

### ¿Qué nivel de riesgo debo tratar primero?

Los riesgos **Críticos** (15–25) y **Altos** (10–14) deben tratarse con prioridad. La Matriz de Riesgos le ayuda a visualizar qué activos requieren atención inmediata.

---

### ¿Con qué frecuencia debo hacer evaluaciones de riesgo?

Según ISO/IEC 27001, las evaluaciones deben realizarse:
- Al incorporar un nuevo activo al inventario
- Cuando cambian las condiciones del activo o el entorno
- Al menos **una vez al año** como revisión periódica

---

### ¿Los reportes PDF tienen información en tiempo real?

Sí. Cada reporte se genera al momento de solicitarlo con los datos más actuales del sistema.

---

### ¿Por qué no puedo descargar el respaldo que generé ayer?

En la plataforma donde está alojado el sistema (Render), los archivos del servidor se pierden cuando el servidor se reinicia o actualiza. **Descargue siempre los respaldos inmediatamente** después de generarlos si los necesita conservar. Los metadatos del respaldo (fecha, tamaño, estado) permanecen en la base de datos aunque el archivo ya no esté disponible.

---

### ¿Qué significa el color del nivel de riesgo?

| Color | Nivel | Rango | Qué hacer |
|-------|-------|-------|-----------|
| 🟢 Verde | Bajo | 1–4 | Monitorear periódicamente |
| 🟡 Amarillo | Medio | 5–9 | Planificar mejoras |
| 🟠 Naranja | Alto | 10–14 | Actuar con prioridad |
| 🔴 Rojo | Crítico | 15–25 | Actuar de inmediato |

---

### ¿Mi avatar se pierde si el servidor se reinicia?

No. Las fotos de perfil se guardan directamente en la base de datos PostgreSQL, no en el servidor de archivos. Esto garantiza que su avatar persista ante cualquier reinicio o actualización del sistema.

---

## INFORMACIÓN DE CONTACTO Y SOPORTE

Para soporte técnico o consultas sobre el sistema:

**Administrador del sistema:** Mario Álvarez  
**Email:** mario.alvarezr@campusucc.edu.co  
**Organización:** Grupo 4 — Universidad Cooperativa de Colombia  

---

*RiskGuard TI — Sistema de Gestión de Riesgos de Seguridad de la Información*  
*Versión 1.0 · Mayo 2026 · Alineado a ISO/IEC 27001:2022*
