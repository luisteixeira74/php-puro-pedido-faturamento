<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Integration\FaturamentoIntegratorService;
use App\DTO\PedidoDTO;

class FaturamentoIntegratorServiceTest extends TestCase
{
    public function testIntegrarMostraMensagemEsperada(): void
    {
        $this->expectOutputString("[Faturamento] Emitindo nota para o pedido #1 no valor de R$ 100\n");

        $faturamento = new FaturamentoIntegratorService();
        $pedido = new PedidoDTO(1, 'Manuel da Silva', 100.0);
        $faturamento->integrar($pedido);
    }
}
