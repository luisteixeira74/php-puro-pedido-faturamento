<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Integration\IntegradorMultiploService;
use App\Integration\PedidoIntegratorInterface;
use Domain\Entity\Pedido;
use App\Repository\PedidoRepository;

class IntegradorMultiploServiceTest extends TestCase
{
    public function testTodosOsIntegradoresSaoExecutadosComOMesmoPedido(): void
    {
        // Given: pedido e dois integradores mockados
        $pedido = new Pedido(1, 'José da Silva', 'Novo pedido', 100.0);

        $integrador1 = $this->createMock(PedidoIntegratorInterface::class);
        $integrador2 = $this->createMock(PedidoIntegratorInterface::class);

        $integrador1->expects($this->once())
                    ->method('integrar')
                    ->with($pedido);

        $integrador2->expects($this->once())
                    ->method('integrar')
                    ->with($pedido);

        $repoMock = $this->createMock(PedidoRepository::class);

        // When: serviço de integração múltipla é executado
        $servico = new IntegradorMultiploService([$integrador1, $integrador2], $repoMock);
        $servico->integrarTudo($pedido);

        // Then: asserções feitas com ->expects()
    }
}
