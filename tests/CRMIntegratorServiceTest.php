<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Integration\CRMIntegratorService;
use Domain\Entity\Pedido;

class CRMIntegratorServiceTest extends TestCase
{
    public function testIntegrarMostraMensagemEsperada(): void
    {
        $this->expectOutputString("[CRM] Registrando cliente Manuel da Silva no CRM\n");

        $crm = new CRMIntegratorService();
        $pedido = new Pedido(1, 'Manuel da Silva', 'Novo pedido', 100.0);
        $crm->integrar($pedido);
    }
}
