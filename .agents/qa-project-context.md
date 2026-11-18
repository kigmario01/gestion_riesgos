# QA Project Context — RiskGuard TI

> Contexto técnico de QA para el Sistema de Gestión de Riesgos de TI.
> Las skills de QA leen este archivo para generar pruebas precisas y alineadas al stack.

---

## Product

- **Name:** RiskGuard TI
- **Type:** Web Application (Sistema de Gestión de Seguridad y Riesgos de TI)
- **Description:** Plataforma integral para la identificación, evaluación, matriz de riesgos, mitigación y auditoría de activos de tecnología de la información.
- **URLs:**
  - Local (XAMPP): http://127.0.0.1/gestion_riesgos/public
  - Login URL: http://127.0.0.1/gestion_riesgos/public/login
- **Key User Flows:**
  1. Autenticación y control de accesos (Login, control de tema claro/oscuro, logout).
  2. Gestión de Activos TI (Crear, ver, editar, clasificar activos críticos).
  3. Gestión de Amenazas y Vulnerabilidades.
  4. Evaluación de Riesgos y visualización de la Matriz de Riesgos.
  5. Planes de Mitigación y seguimiento de acciones correctivas.
  6. Gestión de Usuarios, Roles y Permisos (Spatie / RBAC).
  7. Bitácora de eventos y Respaldos de base de datos.

---

## Tech Stack

### Frontend
- **Templating:** Laravel Blade
- **CSS / Styling:** Tailwind CSS + PostCSS + Google Fonts (Inter)
- **Interactivity:** AlpineJS + JavaScript Vanilla (Tema claro/oscuro, toggles)
- **Bundler:** Vite

### Backend
- **Framework:** Laravel (PHP 8.3)
- **Web Server:** Apache (XAMPP) en Windows
- **Architecture:** MVC con Controladores de Recursos, Middlewares y Policies

### Database
- **Engine:** MySQL / MariaDB en XAMPP
- **ORM:** Eloquent

---

## Test Stack

### E2E / Automatización
- **Framework:** Playwright (`@playwright/test`)
- **Language:** JavaScript (ESM) / TypeScript
- **Target URL:** `http://127.0.0.1/gestion_riesgos/public`
- **Config:** `playwright.config.mjs`
- **Directory:** `tests/e2e/`
- **Browser:** Chromium

### A11y & Accesibilidad
- **Tool:** `@axe-core/playwright`
- **Standard:** WCAG 2.2 AA

---

## Conventions

### Selectors (E2E)
- **Inputs por ID y Name:** `page.locator('#email')`, `page.locator('#password')` o `page.getByLabel('Correo Electrónico')`.
- **Botones por ID / Role:** `page.locator('#loginBtn')` o `page.getByRole('button', { name: 'Ingresar' })`.
- **Evitar:** Selectores frágiles basados en clases Tailwind largas o XPath absolutos.
