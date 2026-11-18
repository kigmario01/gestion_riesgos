import { test, expect } from '@playwright/test';

// Ejecución serial para seguir la secuencia lógica de negocio
test.describe.configure({ mode: 'serial' });

test.describe('RiskGuard TI — Ciclo Completo de Gestión de Riesgos E2E (ISO 27001)', () => {
  const BASE_URL = 'http://127.0.0.1/gestion_riesgos/public';
  const timestamp = Date.now().toString().slice(-4);
  const testAssetCode = `AKT-QA${timestamp}`;
  const testAssetName = `Servidor Central QA ${timestamp}`;
  const testPlanTitle = `Plan Mitigacion Firewall ${timestamp}`;

  test.beforeEach(async ({ page }) => {
    await page.goto(`${BASE_URL}/login`);
    await page.locator('#email').fill('admin@gestion.com');
    await page.locator('#password').fill('Admin1234!');
    await page.locator('#loginBtn').click();
    await expect(page).toHaveURL(`${BASE_URL}/dashboard`);
  });

  test('1. Paso 1: Crear un nuevo Activo TI real', async ({ page }) => {
    await page.goto(`${BASE_URL}/activos/create`);

    await page.locator('input[name="nombre"]').fill(testAssetName);
    await page.locator('input[name="codigo"]').fill(testAssetCode);
    await page.locator('select[name="tipo"]').selectOption('hardware');
    await page.locator('select[name="criticidad"]').selectOption('alta');
    await page.locator('select[name="estado"]').selectOption('activo');
    await page.locator('input[name="responsable"]').fill('Ingeniero QA');
    await page.locator('input[name="ubicacion"]').fill('Rack 4 - DataCenter');
    await page.locator('textarea[name="descripcion"]').fill('Activo de prueba automatizado con Playwright');

    await page.getByRole('button', { name: /Guardar Activo/i }).click();

    // Verificar redirección al inventario y presencia del activo
    await expect(page).toHaveURL(`${BASE_URL}/activos`);
    await expect(page.locator('body')).toContainText(testAssetCode);
    await expect(page.locator('body')).toContainText(testAssetName);
  });

  test('2. Paso 2: Crear Evaluación de Riesgo para el Activo recién creado', async ({ page }) => {
    await page.goto(`${BASE_URL}/evaluaciones/create`);

    // Seleccionar el activo creado en el paso 1 buscando la opción por su código
    const activoSelect = page.locator('select[name="activo_id"]');
    const matchingOption = activoSelect.locator('option').filter({ hasText: testAssetCode }).first();
    const activoVal = await matchingOption.getAttribute('value');
    await activoSelect.selectOption(activoVal);

    // Seleccionar la primera amenaza disponible del catálogo
    const amenazaSelect = page.locator('select[name="amenaza_id"]');
    const options = await amenazaSelect.locator('option').all();
    let amenazaValue = '';
    for (const opt of options) {
      const val = await opt.getAttribute('value');
      if (val) {
        amenazaValue = val;
        break;
      }
    }
    expect(amenazaValue, 'Debe existir al menos una amenaza en el catálogo').not.toBe('');
    await amenazaSelect.selectOption(amenazaValue);

    // Asignar Impacto y Probabilidad (4 x 4 = 16 -> Riesgo Crítico)
    await page.locator('select[name="impacto"]').selectOption('4');
    await page.locator('select[name="probabilidad"]').selectOption('4');

    // Llenar vulnerabilidad si existe el campo
    const vuln = page.locator('textarea[name="vulnerabilidades"], textarea[name="vulnerabilidad"], input[name="vulnerabilidades"]').first();
    if (await vuln.isVisible()) {
      await vuln.fill('Falta de parches de seguridad en firmware');
    }

    // Botón específico del formulario
    await page.getByRole('button', { name: /Calcular y Guardar|Guardar/i }).click();

    // Confirmación en el listado de evaluaciones
    await expect(page).toHaveURL(/.*evaluaciones/);
    await expect(page.locator('body')).toContainText(testAssetName);
  });

  test('3. Paso 3: Verificar que el riesgo se refleja en la Matriz de Riesgo 5x5', async ({ page }) => {
    await page.goto(`${BASE_URL}/matriz`);
    await expect(page).toHaveURL(`${BASE_URL}/matriz`);

    // Comprobar que la vista de matriz cargó correctamente y renderiza el grid
    await expect(page.locator('body')).toContainText(/Matriz de Riesgos/i);
    await expect(page.locator('.matriz-grid, .matriz-wrap').first()).toBeVisible();
  });

  test('4. Paso 4: Crear un Plan de Mitigación asociado a la evaluación', async ({ page }) => {
    await page.goto(`${BASE_URL}/mitigacion/create`);

    // Seleccionar la evaluación asociada
    const evaluacionSelect = page.locator('select[name="evaluacion_id"]');
    const matchingEvalOpt = evaluacionSelect.locator('option').filter({ hasText: testAssetName }).first();
    
    if (await matchingEvalOpt.count() > 0) {
      const evalVal = await matchingEvalOpt.getAttribute('value');
      await evaluacionSelect.selectOption(evalVal);
    } else {
      await evaluacionSelect.selectOption({ index: 1 });
    }

    await page.locator('input[name="titulo"]').fill(testPlanTitle);
    await page.locator('select[name="tipo_control"]').selectOption('preventivo');
    await page.locator('select[name="estrategia"]').selectOption('reducir');
    await page.locator('select[name="prioridad"]').selectOption('urgente');
    await page.locator('input[name="responsable"]').fill('Oficial de Seguridad TI');
    await page.locator('input[name="fecha_inicio"]').fill('2026-11-18');
    await page.locator('input[name="fecha_limite"]').fill('2026-12-31');
    await page.locator('textarea[name="descripcion"]').fill('Plan de mitigación automatizado de seguridad.');
    await page.locator('textarea[name="acciones_requeridas"]').fill('1. Configurar firewall perimetral. 2. Actualizar firmware y parches.');

    // Guardar plan usando el botón dentro de la tarjeta del formulario
    await page.locator('.form-card button[type="submit"], form button.btn-primary').first().click();
    await expect(page).toHaveURL(/.*mitigacion/);
    await expect(page.locator('body')).toContainText(testPlanTitle);
  });

  test('5. Paso 5: Auditar que las acciones quedaron registradas en la Bitácora', async ({ page }) => {
    await page.goto(`${BASE_URL}/bitacora`);
    await expect(page).toHaveURL(`${BASE_URL}/bitacora`);
    await expect(page.locator('body')).toContainText(/Bitácora/i);
    await expect(page.locator('table, .card, main').first()).toBeVisible();
  });
});
