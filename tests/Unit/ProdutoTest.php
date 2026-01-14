<?php

namespace Tests\Unit;

use App\Models\Produto;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    public function test_codigo_produto_deve_ter_13_digitos()
    {
        $produto = new Produto();

        $codigoValido = '1234567890123';
        $produto->codigo = $codigoValido;
        
        $this->assertEquals($codigoValido, $produto->codigo);
    }

    public function test_codigo_produto_lanca_excecao_se_invalido()
    {
        $this->expectException(ValidationException::class);
        
        $produto = new Produto();
        $produto->codigo = '123'; // Inválido
    }

    public function test_valor_unitario_deve_ser_numerico()
    {
        $produto = new Produto();
        
        $valor = 10.50;
        $produto->valor_unitario = $valor;
        
        $this->assertEquals($valor, $produto->valor_unitario);
    }

    public function test_valor_unitario_lanca_excecao_se_nao_numerico()
    {
        $this->expectException(ValidationException::class);
        
        $produto = new Produto();
        $produto->valor_unitario = 'abc';
    }
}
