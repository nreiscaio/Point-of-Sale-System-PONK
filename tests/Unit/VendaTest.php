<?php

namespace Tests\Unit;

use App\Models\Venda;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class VendaTest extends TestCase
{
    public function test_saldo_inicial_deve_ser_numerico()
    {
        $venda = new Venda();
        
        $valor = 100.50;
        $venda->saldoInicial = $valor; 
        
        $this->assertEquals($valor, $venda->valor_total);
    }

    public function test_saldo_inicial_nao_pode_ser_negativo()
    {
        $this->expectException(ValidationException::class);
        
        $venda = new Venda();
        $venda->saldoInicial = -10;
    }

    public function test_status_valido_e_aceito()
    {
        $venda = new Venda();
        $venda->status = 'finalizada';

        $this->assertEquals('finalizada', $venda->status);
    }

    public function test_status_invalido_lanca_excecao()
    {
        $this->expectException(ValidationException::class);

        $venda = new Venda();
        $venda->status = 'invalido';
    }

    public function test_cpf_invalido_lanca_excecao()
    {
        $this->expectException(ValidationException::class);

        $venda = new Venda();
        $venda->cpf_cliente = "000";
    }
}
