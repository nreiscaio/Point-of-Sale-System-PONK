import { test, expect } from '@playwright/test';

test.describe('Testes de Sistema - Fluxo de Venda', () => {
    
    test('Fluxo Completo: Login, Abertura de Caixa, Venda com Item e Fechamento', async ({ page }) => {
        test.setTimeout(120000);
        
        await page.goto('http://localhost:8000');
        await page.getByTestId('login-email').fill('playwright@testing.com'); 
        await page.getByTestId('login-password').fill('testing123'); 
        await page.keyboard.press('Enter');
        
        await expect(page.locator('text=Bem-vindo')).toBeVisible({ timeout: 15000 }).catch(() => {});

        await page.keyboard.press('F2'); 
        await page.waitForURL(/\/statusCaixa/);
        
        const btnAbrir = page.getByRole('button', { name: /abrir caixa/i });
        if (await btnAbrir.isVisible()) {
             await btnAbrir.click();
             await expect(page.getByText('Caixa Aberto')).toBeVisible();
        }

        await page.keyboard.press('F1');
        await page.waitForURL(/\/pointOfSale/);
        
        const codigoInput = page.getByTestId('input-codigo-produto');
        await expect(codigoInput).toBeVisible();
        
        await codigoInput.fill('1111111111111'); 
        await page.keyboard.press('Enter');
        
        await expect(page.getByTestId('linha-item')).toHaveCount(1);
        
        await page.keyboard.press('F4');
        await page.keyboard.press('F7'); 
        
        await expect(page.getByTestId('inserir-valor-popup')).toBeVisible();
        const valorInput = page.getByTestId('inserir-valor-input');
        
        await valorInput.fill('100');
        await valorInput.press('Enter');
        
        await page.keyboard.press('F4'); 
        await expect(page.getByTestId('finalizar-venda-popup')).toBeVisible();
        await page.keyboard.press('Enter'); 
        
        await expect(page.getByTestId('linha-item')).toHaveCount(0);
        
        await page.keyboard.press('F2'); 
        await page.waitForURL(/\/statusCaixa/);
        
        const btnFechar = page.getByRole('button', { name: /fechar caixa/i });
        await btnFechar.click();
        
        const btnConfirmar = page.getByRole('button', { name: /confirmar/i });
        if (await btnConfirmar.isVisible()) {
             await btnConfirmar.click();
        }
        
        await expect(page.getByText('Caixa Fechado')).toBeVisible();
    });
});