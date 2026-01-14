<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Caixa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FluxoCompletoVendaTest extends TestCase
{
    public function test_fluxo_completo_venda_backend()
    {
        $user = User::factory()->create();
        
        $caixa = Caixa::create([
            'user_id' => $user->id,
            'aberto' => true,
            'saldo_inicial' => 100.00,
            'status_alterado_em' => now()
        ]);
        
        $this->actingAs($user);
        
        $this->assertAuthenticatedAs($user);
        $this->assertTrue((bool)$caixa->aberto);

        $dadosVenda = [
            'forma_pagamento' => 'Dinheiro',
            'valor_total' => 50.00,
            'status' => 'Concluída',
            'caixa_id' => $caixa->numeracao,
            'cpf_cliente' => null,
        ];

        $responseVenda = $this->post(route('vendas.store'), $dadosVenda);
        
        $responseVenda->assertStatus(302);
        
        $this->assertDatabaseHas('vendas', [
            'usuario_id' => $user->id,
            'caixa_id' => $caixa->numeracao,
            'valor_total' => 50.00
        ]);
        
        $responseFechar = $this->post(route('StatusCaixa.acoesCaixa', ['acao' => 'fechar']));
        
        $status = $responseFechar->status();
        $this->assertTrue(in_array($status, [200, 302])); 
        
        $caixa->refresh();
        $this->assertFalse((bool)$caixa->aberto);
    }
}
