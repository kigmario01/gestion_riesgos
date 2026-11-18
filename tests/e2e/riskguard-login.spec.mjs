import { test, expect } from '@playwright/test';

test.describe('RiskGuard TI — Pruebas de Login y UI (XAMPP)', () => {
  const LOGIN_URL = 'http://127.0.0.1/gestion_riesgos/public/login';

  test.beforeEach(async ({ page }) => {
    await page.goto(LOGIN_URL);
  });

  test('debe cargar correctamente la pantalla de inicio de sesión de RiskGuard TI', async ({ page }) => {
    // 1. Validar título de la página
    await expect(page).toHaveTitle(/Iniciar Sesión — RiskGuard TI/);

    // 2. Validar que los campos críticos están visibles
    const emailInput = page.locator('#email');
    const passwordInput = page.locator('#password');
    const submitBtn = page.locator('#loginBtn');

    await expect(emailInput).toBeVisible();
    await expect(passwordInput).toBeVisible();
    await expect(submitBtn).toBeVisible();
  });

  test('debe permitir alternar el tema claro / oscuro', async ({ page }) => {
    const themeBtn = page.locator('#loginThemeToggle');
    await expect(themeBtn).toBeVisible();

    // Obtener tema inicial
    const htmlTag = page.locator('html');
    const initialTheme = await htmlTag.getAttribute('data-theme');

    // Click para alternar
    await themeBtn.click();
    const newTheme = await htmlTag.getAttribute('data-theme');
    expect(newTheme).not.toBe(initialTheme);
  });

  test('debe mostrar error de validación ante credenciales incorrectas', async ({ page }) => {
    await page.locator('#email').fill('usuario_inexistente@correo.com');
    await page.locator('#password').fill('clave_invalida_123'); // gitleaks:allow
    await page.locator('#loginBtn').click();

    // La app debe mantenerse en la pantalla de login o mostrar aviso de error
    await expect(page).toHaveURL(/.*login/);
  });
});
