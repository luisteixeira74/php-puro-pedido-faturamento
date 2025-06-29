<?php

namespace App\Integration;

use Domain\Entity\Pedido;

class FaturamentoIntegratorService implements PedidoIntegratorInterface
{
    public function integrar(Pedido $pedido): void
    {
        error_log("[Faturamento] Emitindo nota para o pedido #{$pedido->getId()} no valor de R$ {$pedido->getValor()}\n");
    }
}
