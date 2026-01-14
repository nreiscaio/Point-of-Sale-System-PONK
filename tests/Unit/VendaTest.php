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
        // setSaldoInicialAttribute é mapeado para 'valor_total' no setter customizado do modelo Venda.php que li
        $venda->saldoInicial = $valor; 
        
        $this->assertEquals($valor, $venda->valor_total);
    }

    public function test_saldo_inicial_nao_pode_ser_negativo()
    {
        $this->expectException(ValidationException::class);
        
        $venda = new Venda();
        $venda->saldoInicial = -10;
        
        // O setter 'setSaldoInicialAttribute' lanca excecao se valor < 0
    }
}
