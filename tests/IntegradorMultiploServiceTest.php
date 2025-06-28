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
        $pedidoDTO = new PedidoDTO(1, 'José da Silva', 'Novo pedido', 100.0);

        // Converte para Entity antes de usar no domínio
        $pedidoEntity = new \Domain\Entity\Pedido(
            $pedidoDTO->id,
            $pedidoDTO->cliente,
            $pedidoDTO->descricao,
            $pedidoDTO->valor
        );

        $mock1 = $this->createMock(PedidoIntegratorInterface::class);
        $mock2 = $this->createMock(PedidoIntegratorInterface::class);

        $mock1->expects($this->once())
              ->method('integrar')
              ->with($pedidoEntity);

        $mock2->expects($this->once())
              ->method('integrar')
              ->with($pedidoEntity);

        $service = new IntegradorMultiploService([$mock1, $mock2], 
            $this->createMock(\App\Repository\PedidoRepository::class));
        $service->integrarTudo($pedidoEntity);
    }
}
