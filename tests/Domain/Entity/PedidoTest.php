<?php

namespace Tests\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Domain\Entity\Pedido;

class PedidoTest extends TestCase
{
    public function testAplicarDescontoDezPorCento()
    {
        // Arrange
        $pedido = new Pedido(
            id: 123,
            cliente: 'Cliente VIP',
            descricao: 'Compra grande',
            valor: 50.00
        );

        // Act
        $pedido->aplicarDesconto(10.0);

        // Assert
        $this->assertEquals(45.00, $pedido->getValor());
        $this->assertTrue($pedido->isDescontoAplicado());
    }

    public function testLimiteDesconto()
    {
        // Arrange
        $pedido = new Pedido(
            id: 123,
            cliente: 'Cliente VIP',
            descricao: 'Compra grande',
            valor: 550.00
        );

        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Percentual inválido para desconto');

        // Act
        $pedido->aplicarDesconto(500);
    }
}
