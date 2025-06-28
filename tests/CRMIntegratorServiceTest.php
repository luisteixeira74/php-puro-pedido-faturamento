<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Integration\CRMIntegratorService;
use App\DTO\PedidoDTO;

class CRMIntegratorServiceTest extends TestCase
{
    public function testIntegrarMostraMensagemEsperada(): void
    {
        $this->expectOutputString("[CRM] Registrando cliente Manuel da Silva no CRM\n");

        $crm = new CRMIntegratorService();
        $pedido = new PedidoDTO(1, 'Manuel da Silva', 'Novo pedido', 100.0);
        $crm->integrar($pedido);
    }
}
