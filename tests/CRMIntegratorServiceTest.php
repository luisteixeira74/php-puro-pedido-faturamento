<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Integration\CRMIntegratorService;
use Domain\Entity\Pedido;
use Domain\Log\LoggerInterface;

class CRMIntegratorServiceTest extends TestCase
{
    public function testIntegrarEnviaMensagemParaLogger(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects($this->once())
               ->method('log')
               ->with($this->equalTo("[CRM] Registrando cliente Manuel da Silva no CRM\n"));

        $crm = new CRMIntegratorService($logger);
        $pedido = new Pedido(1, 'Manuel da Silva', 'Novo pedido', 100.0);

        $crm->integrar($pedido);
    }
}