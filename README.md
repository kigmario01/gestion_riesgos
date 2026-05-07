# RiskGuard TI — Sistema de Gestión de Riesgos

<div align="center">

![RiskGuard TI](https://img.shields.io/badge/RiskGuard-TI-f97316?style=for-the-badge&logo=shield&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Deployed-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![ISO 27001](https://img.shields.io/badge/ISO%2FIEC-27001%3A2022-16a34a?style=for-the-badge&logoColor=white)

**Sistema web de gestión de riesgos de seguridad de la información alineado a ISO/IEC 27001:2022**

[🚀 Ver Demo en Vivo](https://gestion-riesgos-7d9n.onrender.com) &nbsp;·&nbsp; [📖 Documentación Técnica](./DOCUMENTACION_IEEE26511.md) &nbsp;·&nbsp; [📘 Manual de Usuario](./MANUAL_USUARIO.md)

</div>

---

## 📸 Capturas de Pantalla

<div align="center">

| Dashboard | Matriz de Riesgos |
|:---------:|:-----------------:|
| ![Dashboard](docs/screenshots/dashboard.png) | ![Matriz](docs/screenshots/matriz.png) |

| Evaluación de Riesgos | Gestión de Usuarios |
|:---------------------:|:-------------------:|
| ![Evaluaciones](docs/screenshots/evaluaciones.png) | ![Usuarios](docs/screenshots/usuarios.png) |

</div>

> 🔗 **[Demo en vivo → gestion-riesgos-7d9n.onrender.com](https://gestion-riesgos-7d9n.onrender.com)**  
> Credenciales demo: `admin@gestion.com` / `password`

---

## ✨ Características Principales

### 📦 Gestión de Activos TI
Inventario completo de activos tecnológicos con clasificación por criticidad (Bajo / Medio / Alto / Crítico), control de propietario, ubicación, valor económico y estado operativo.

### ⚠️ Catálogo de Amenazas
Amenazas predefinidas basadas en ISO/IEC 27005 más la posibilidad de registrar amenazas propias de la organización, clasificadas por categoría y nivel de probabilidad e impacto.

### 📊 Evaluación y Cálculo de Riesgos
Cálculo automático del nivel de riesgo (`Probabilidad × Impacto`) con clasificación en 4 niveles visuales. Seguimiento del estado de cada riesgo a lo largo del tiempo.

### 🛡️ Planes de Mitigación
Gestión de acciones de tratamiento con 4 tipos (Reducir, Aceptar, Transferir, Evitar), flujo de aprobación por roles, seguimiento de responsables, fechas y costos.

### 🗺️ Matriz de Riesgos Interactiva
Visualización 5×5 de probabilidad vs impacto con código de colores. Permite identificar de un vistazo los activos más críticos de la organización.

### 📋 Bitácora de Auditoría
Registro automático e inmutable de cada acción CUD con usuario, timestamp (zona horaria Colombia) y estado antes/después del cambio. Cumple con A.12.4.1 de ISO 27001.

### 📄 Reportes PDF
6 tipos de reportes exportables: Ejecutivo, Activos TI, Amenazas, Evaluaciones, Mitigación y Bitácora. Generados con DomPDF listos para auditores o directivos.

### 👥 Control de Acceso Granular (RBAC)
7 roles predefinidos con más de 30 permisos individuales por módulo. Activación/desactivación de usuarios en tiempo real con cierre automático de sesiones activas.

### 💾 Respaldo Automático de BD
Respaldo manual inmediato y respaldo automático configurable (hora, frecuencia: diario / semanal / mensual). Compatible con PostgreSQL y MySQL mediante PDO dump. Gestionado por el scheduler de Laravel corriendo en Supervisor.

### 🎨 Interfaz Moderna con Modo Oscuro
Diseño personalizado sin frameworks CSS externos, modo claro/oscuro persistente por usuario, y avatar de perfil almacenado en base64 en PostgreSQL para sobrevivir reinicios del servidor.

---

## 🛠️ Stack Tecnológico

| Capa | Tecnología | Versión |
|------|-----------|---------|
| Backend | Laravel | 13.x |
| Lenguaje | PHP | 8.3 |
| Base de datos | PostgreSQL (prod) / MySQL (dev) | 15 |
| Frontend | Blade + CSS propio + JS vanilla | — |
| Autenticación | Laravel Breeze (adaptado) | — |
| Autorización | Spatie Laravel Permission | 7.2 |
| PDF | barryvdh/laravel-dompdf | 3.1 |
| Contenedor | Docker (php:8.3-fpm-alpine) | — |
| Servidor web | Nginx + PHP-FPM | — |
| Procesos | Supervisor | — |
| Despliegue | Render.com | — |

---

## 🚀 Instalación Local

### Con XAMPP

```bash
# Clonar el repositorio
git clone https://github.com/kigmario01/gestion_riesgos.git
cd gestion_riesgos

# Instalar dependencias
composer install
npm install && npm run build

# Configurar entorno
cp .env.example .env
php artisan key:generate
```

Edita `.env` con tus datos de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_riesgos
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# Migrar y sembrar datos
php artisan migrate --seed

# Crear enlace de storage
php artisan storage:link

# Iniciar servidor
php artisan serve
```

Abre **http://localhost:8000**

---

### Con Docker

```bash
git clone https://github.com/kigmario01/gestion_riesgos.git
cd gestion_riesgos

# Configurar variables de entorno
cp .env.example .env
# (edita .env con tus datos de PostgreSQL)

# Construir imagen
docker build -t riskguard-ti .

# Correr contenedor
docker run -p 8000:8000 --env-file .env riskguard-ti
```

Abre **http://localhost:8000**

---

## 🔑 Credenciales de Demo

| Rol | Email | Contraseña |
|-----|-------|-----------|
| Administrador | admin@gestion.com | password |
| Gestor de Riesgos | mario.alvarez@gestion.com | password |
| Auditor | medra@gestion.com | password |

---

## 📁 Estructura del Proyecto

```
gestion_riesgos/
├── app/
│   ├── Console/Commands/      # RespaldoAutomatico, FixAdminPerms
│   ├── Http/
│   │   ├── Controllers/       # 13 controladores de módulos
│   │   └── Middleware/        # CheckUsuarioActivo
│   └── Models/                # 8 modelos Eloquent
├── database/
│   ├── migrations/            # 15 migraciones
│   └── seeders/               # Roles, permisos, amenazas ISO
├── resources/views/           # Plantillas Blade por módulo
├── routes/
│   ├── web.php                # Rutas con middleware de permisos
│   └── console.php            # Tareas programadas
├── docker/
│   ├── nginx.conf
│   └── supervisord.conf       # nginx + php-fpm + scheduler
├── Dockerfile
├── DOCUMENTACION_IEEE26511.md
└── MANUAL_USUARIO.md
```

---

## 📐 Controles ISO/IEC 27001:2022 Implementados

| Control Anexo A | Módulo |
|-----------------|--------|
| A.8 — Gestión de activos | Activos TI |
| A.6.1 — Inteligencia de amenazas | Amenazas |
| A.8.2 — Evaluación de riesgos | Evaluaciones |
| A.8.3 — Tratamiento de riesgos | Mitigación |
| A.9.2 — Gestión de identidades | Usuarios |
| A.9.4 — Control de acceso | RBAC con Spatie |
| A.12.3 — Copias de seguridad | Respaldos BD |
| A.12.4 — Registro de eventos | Bitácora |

---

## 📖 Documentación

| Documento | Descripción |
|-----------|-------------|
| [📄 DOCUMENTACION_IEEE26511.md](./DOCUMENTACION_IEEE26511.md) | Documentación técnica completa: arquitectura, módulos, modelo de datos, seguridad, despliegue |
| [📘 MANUAL_USUARIO.md](./MANUAL_USUARIO.md) | Manual de usuario final con guías paso a paso para cada módulo |

---

## 👨‍💻 Autor

**Mario De Jesús Álvarez Ramos**  
Ingeniería de Sistemas — Universidad Cooperativa de Colombia ·

[![GitHub](https://img.shields.io/badge/GitHub-kigmario01-181717?style=flat-square&logo=github)](https://github.com/kigmario01)
[![Email](https://img.shields.io/badge/Email-mario.alvarezr%40campusucc.edu.co-EA4335?style=flat-square&logo=gmail&logoColor=white)](mailto:mario.alvarezr@campusucc.edu.co)

---

<div align="center">

Construido con Laravel 13 · PHP 8.3 · PostgreSQL · Docker · Render

*Alineado a ISO/IEC 27001:2022 — Sistema de Gestión de Seguridad de la Información*

</div>
