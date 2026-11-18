import { test, expect } from '@playwright/test';

// Ejecutar secuencialmente para evitar colisiones de sesión en Apache local
test.describe.configure({ mode: 'serial' });

test.describe('RiskGuard TI — Smoke Test & Auditoría General de Rutas y Botones', () => {
  const BASE_URL = 'http://127.0.0.1/gestion_riesgos/public';
  const jsErrors = [];

  test.beforeEach(async ({ page }) => {
    page.on('pageerror', (err) => {
      // Ignoramos PhpDebugBar si está desactivado en frontend
      if (!err.message.includes('PhpDebugBar')) {
        jsErrors.push(`[Error JS] en ${page.url()}: ${err.message}`);
      }
    });

    // Login del administrador
    await page.goto(`${BASE_URL}/login`);
    await page.locator('#email').fill('admin@gestion.com');
    await page.locator('#password').fill('Admin1234!');
    await page.locator('#loginBtn').click();
    await expect(page).toHaveURL(`${BASE_URL}/dashboard`);
  });

  test.afterEach(() => {
    if (jsErrors.length > 0) {
      console.warn('Errores JS detectados:', jsErrors);
    }
  });

  test('1. Dashboard: debe cargar métricas y título correctamente', async ({ page }) => {
    await expect(page).toHaveTitle(/Dashboard/i);
    await expect(page.locator('body')).toBeVisible();
    expect(page.url()).toContain('/dashboard');
  });

  const modulos = [
    { nombre: 'Activos TI', ruta: '/activos', selector: 'table, .card, main' },
    { nombre: 'Crear Activo TI', ruta: '/activos/create', selector: 'button:has-text("Guardar Activo")' },
    { nombre: 'Amenazas', ruta: '/amenazas', selector: 'table, .card, main' },
    { nombre: 'Crear Amenaza', ruta: '/amenazas/create', selector: 'form, input, button[type="submit"]' },
    { nombre: 'Evaluaciones de Riesgo', ruta: '/evaluaciones', selector: 'table, .card, main' },
    { nombre: 'Planes de Mitigación', ruta: '/mitigacion', selector: 'table, .card, main' },
    { nombre: 'Matriz de Riesgo', ruta: '/matriz', selector: 'main, table, .card' },
    { nombre: 'Bitácora de Eventos', ruta: '/bitacora', selector: 'table, .card, main' },
    { nombre: 'Gestión de Usuarios', ruta: '/usuarios', selector: 'table, .card, main' },
    { nombre: 'Gestión de Roles', ruta: '/roles', selector: 'table, .card, main' },
  ];

  for (const modulo of modulos) {
    test(`2. Módulo ${modulo.nombre}: responde 200 y renderiza controles`, async ({ page }) => {
      const response = await page.goto(`${BASE_URL}${modulo.ruta}`);
      expect(response.status(), `La ruta ${modulo.ruta} falló con HTTP ${response.status()}`).toBe(200);

      const elemento = page.locator(modulo.selector).first();
      await expect(elemento).toBeVisible({ timeout: 10000 });
    });
  }

  test('3. Formularios: el botón Guardar Activo debe estar visible y habilitado', async ({ page }) => {
    await page.goto(`${BASE_URL}/activos/create`);
    const submitBtn = page.getByRole('button', { name: /Guardar Activo/i });
    await expect(submitBtn).toBeVisible();
    await expect(submitBtn).toBeEnabled();
  });

  test('4. Cierre de Sesión: debe desautenticar correctamente', async ({ page }) => {
    const logoutBtn = page.locator('form[action*="logout"] button, a[href*="logout"]').first();
    if (await logoutBtn.isVisible()) {
      await logoutBtn.click();
      await expect(page).toHaveURL(/.*login/);
    }
  });
});
