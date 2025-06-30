<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Integration\FaturamentoIntegratorService;
use Domain\Entity\Pedido;
use Domain\Log\LoggerInterface;

class FaturamentoIntegratorServiceTest extends TestCase
{
    public function testIntegrarEnviaMensagemParaLogger(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
               ->method('log')
               ->with($this->equalTo("[Faturamento] Emitindo nota para o pedido #1 no valor de R$ 100,00\n"));

        $faturamento = new FaturamentoIntegratorService($logger);
        $pedido = new Pedido(1, 'Manuel da Silva', 'Novo pedido', 100.0);

        $faturamento->integrar($pedido);
    }
}
