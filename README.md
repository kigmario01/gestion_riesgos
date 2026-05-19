# RiskGuard TI — Sistema de Gestión de Riesgos

Sistema web para la **Gestión de Seguridad de la Información** alineado al estándar
internacional **ISO/IEC 27001:2022**. Permite inventariar activos de TI, identificar
amenazas, evaluar y calcular el riesgo, planificar acciones de mitigación y mantener
una bitácora de auditoría inmutable.

---

## Características

- **Inventario de Activos TI** — registro y clasificación de activos de información.
- **Análisis de Amenazas** — catálogo de amenazas con amenazas iniciales precargadas.
- **Evaluación de Riesgos** — cálculo de riesgo (probabilidad × impacto) y riesgo residual.
- **Matriz de Riesgos 5×5** — visualización de la matriz de riesgos ISO 27001.
- **Planes de Mitigación** — tratamiento del riesgo con seguimiento de avance.
- **Bitácora de Auditoría** — registro inmutable de todas las acciones del sistema.
- **Reportes en PDF** — reportes ejecutivos, de activos, amenazas, evaluaciones y bitácora.
- **Roles y Permisos** — control de acceso granular por módulo.
- **Respaldos de Base de Datos** — respaldo manual y automático programable.
- **Modo claro / oscuro** — interfaz con tema día y noche.

---

## Requisitos

| Componente | Versión |
|------------|---------|
| PHP        | 8.3 o superior |
| Composer   | 2.x |
| Node.js    | 18 o superior (con npm) |
| MySQL / MariaDB | 5.7+ / 10.x |

Extensiones de PHP necesarias: `mbstring`, `pdo_mysql`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`.

> Para generar respaldos con `mysqldump`, el binario debe estar disponible en el sistema
> (en XAMPP suele estar en `C:\xampp\mysql\bin\`). Si no está, el sistema usa un respaldo
> alternativo vía PDO automáticamente.

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/kigmario01/gestion_riesgos.git
cd gestion_riesgos
```

### 2. Instalar dependencias

```bash
composer install
npm install
```

### 3. Configurar el entorno

Copia el archivo de ejemplo y genera la clave de la aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` con los datos de tu base de datos:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_riesgos
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Crear la base de datos

Crea una base de datos vacía con el nombre indicado en `DB_DATABASE`
(por ejemplo `gestion_riesgos`) desde phpMyAdmin o por consola.

### 5. Ejecutar migraciones y datos iniciales

```bash
php artisan migrate --seed
```

Esto crea las tablas y carga roles, permisos, amenazas iniciales y usuarios de prueba.

### 6. Compilar los assets

```bash
npm run build
```

### 7. Iniciar el servidor

```bash
php artisan serve
```

La aplicación quedará disponible en **http://localhost:8000**.

> **Atajo:** `composer run dev` levanta a la vez el servidor, la cola, los logs y Vite.

---

## Acceso inicial

El seeder crea los siguientes usuarios de prueba:

| Rol           | Correo                      | Contraseña    |
|---------------|-----------------------------|---------------|
| Administrador | `admin@gestion.com`         | `Admin1234!`  |
| Scrum Master  | `mario.alvarez@gestion.com` | `Scrum1234!`  |

> ⚠️ Cambia estas contraseñas antes de usar el sistema en un entorno real.

---

## Despliegue en XAMPP

1. Coloca el proyecto dentro de `C:\xampp\htdocs\`.
2. Inicia **Apache** y **MySQL** desde el panel de XAMPP.
3. Asegúrate de que en `C:\xampp\php\php.ini` la línea `extension_dir`
   apunte a `"C:/xampp/php/ext"` y que la extensión `mbstring` esté habilitada.
4. Sigue los pasos de instalación anteriores.

---

## Stack tecnológico

- **Backend:** Laravel 13 (PHP 8.3)
- **Frontend:** Blade, Tailwind CSS 3, Alpine.js, Font Awesome
- **Base de datos:** MySQL
- **PDF:** `barryvdh/laravel-dompdf`
- **Permisos:** `spatie/laravel-permission`
- **Build:** Vite

---

## Licencia

Proyecto académico — Gestión de Riesgos TI · Grupo 4. Cumplimiento ISO/IEC 27001:2022.
