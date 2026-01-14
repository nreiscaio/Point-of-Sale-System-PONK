<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VendaIntegrationTest extends TestCase
{
    public function test_usuario_autenticado_pode_criar_venda()
    {
        $user = User::factory()->create();

        $dadosVenda = [
            'forma_pagamento' => 'Dinheiro',
            'valor_total' => 100.00,
            'status' => 'Concluída',
            'caixa_id' => 1,
        ];

        $response = $this->actingAs($user)
                         ->post(route('vendas.store'), $dadosVenda);

        $response->assertStatus(302);
        $response->assertRedirect(route('vendas.index'));

        $this->assertDatabaseHas('vendas', [
            'usuario_id' => $user->id,
            'forma_pagamento' => 'Dinheiro',
            'valor_total' => 100.00
        ]);
    }

    public function test_usuario_nao_autenticado_nao_pode_criar_venda()
    {
        $dadosVenda = [
            'forma_pagamento' => 'Dinheiro',
            'valor_total' => 50.00,
        ];

        $response = $this->post(route('vendas.store'), $dadosVenda);

        $response->assertStatus(302);
    }

    public function test_venda_com_dados_invalidos_eh_rejeitada()
    {
        $user = User::factory()->create();

        $dadosInvalidos = [
            'forma_pagamento' => 'Dinheiro',
            'valor_total' => 100.00,
            'status' => 'StatusInexistente',
            'caixa_id' => 1,
        ];

        $response = $this->actingAs($user)
                         ->post(route('vendas.store'), $dadosInvalidos);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['status']); 
    }
}
