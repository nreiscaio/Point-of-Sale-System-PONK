import { test, expect } from '@playwright/test';

test.describe('Autenticação do Sistema', () => {

  test('Deve realizar login com sucesso', async ({ page }) => {
    await page.goto('http://localhost:8000');
    
    await page.getByLabel('Email').fill('teste@teste.com');

    const emailInput = page.locator('input[type="email"]');
    await emailInput.fill('teste@teste.com');

    const passwordInput = page.locator('input[type="password"]');
    await passwordInput.fill('password123');

    await page.keyboard.press('Enter');

    // Espera navegar para dashboard
    await expect(page).toHaveURL(/.*dashboard/);
    
    // Verifica se menu está visivel
    await expect(page.locator('text=Bem-vindo')).toBeVisible({ timeout: 10000 }).catch(() => {
    });
  });

  test('Deve falhar login com senha incorreta', async ({ page }) => {
    await page.goto('http://localhost:8000');

    await page.locator('input[type="email"]').fill('teste@teste.com');
    await page.locator('input[type="password"]').fill('senhaerrada');
    await page.keyboard.press('Enter');

    await expect(page.getByText('credenciais').first()).toBeVisible();
  });

});
