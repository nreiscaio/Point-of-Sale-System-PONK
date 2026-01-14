<?php

namespace Tests\Unit;

use App\Models\ItemVenda;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ItemVendaTest extends TestCase
{
    public function test_quantidade_deve_ser_numerica_e_maior_que_zero()
    {
        $item = new ItemVenda();
        
        $qtde = 5;
        $item->qtde = $qtde;
        
        $this->assertEquals($qtde, $item->qtde);
    }

    public function test_quantidade_lanca_excecao_se_nao_numerica()
    {
        $this->expectException(ValidationException::class);
        
        $item = new ItemVenda();
        $item->qtde = 'abc';
    }

    public function test_quantidade_lanca_excecao_se_zero_ou_negativa()
    {
        $this->expectException(ValidationException::class);
        
        $item = new ItemVenda();
        $item->qtde = 0;
    }
}
