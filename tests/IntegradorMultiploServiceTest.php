<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Integration\IntegradorMultiploService;
use App\DTO\PedidoDTO;
use App\Integration\PedidoIntegratorInterface;

class IntegradorMultiploServiceTest extends TestCase
{
    public function testChamaTodosOsIntegradores(): void
    {
        $pedido = new PedidoDTO(1, 'Luis Fernando', 100.0);

        $mock1 = $this->createMock(PedidoIntegratorInterface::class);
        $mock2 = $this->createMock(PedidoIntegratorInterface::class);

        $mock1->expects($this->once())
              ->method('integrar')
              ->with($pedido);

        $mock2->expects($this->once())
              ->method('integrar')
              ->with($pedido);

        $service = new IntegradorMultiploService([$mock1, $mock2]);
        $service->integrarTudo($pedido);
    }
}
