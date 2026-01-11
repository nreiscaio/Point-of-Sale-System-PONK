import { test, expect } from '@playwright/test';

test.setTimeout(100000);

test('venda simples em dinheiro apenas com teclado', async ({ page }) => {
  await page.goto('http://localhost:8000');

  // login
  await page.getByTestId('login-email').fill('playwright@testing.com');
  await page.getByTestId('login-password').fill('testing123');
  await page.keyboard.press('Enter');
  await page.waitForTimeout(6000);

  // abrir PDV
  await page.keyboard.press('F1');

  // inserir produto
  const codigo = page.getByTestId('input-codigo-produto');
  await codigo.fill('1111111111111');
  await page.waitForTimeout(1000);
  await codigo.press('Enter');
  await page.waitForTimeout(3000);

  await expect(page.getByTestId('linha-item')).toHaveCount(1);

  // pagamento
  await page.keyboard.press('F4');
  await page.keyboard.press('F7');
  await page.waitForTimeout(1000);
  await expect(page.getByTestId('inserir-valor-popup')).toBeVisible();

  const valor = page.getByTestId('inserir-valor-input');
  await valor.fill('679');
  await page.waitForTimeout(1000);
  await valor.press('Enter');
  await page.waitForTimeout(1000);

  // finalizar
  await page.keyboard.press('F4');
  await page.waitForTimeout(1000);
  await expect(page.getByTestId('finalizar-venda-popup')).toBeVisible();
  await page.keyboard.press('Enter');
  await page.waitForTimeout(2000);

  // sucesso
  await expect(page.getByTestId('linha-item')).toHaveCount(0);
});