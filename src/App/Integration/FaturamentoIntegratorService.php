<?php

namespace App\Integration;

use App\DTO\PedidoDTO;

class FaturamentoIntegratorService implements PedidoIntegratorInterface
{
    public function integrar(PedidoDTO $pedido): void
    {
        echo "[Faturamento] Emitindo nota para o pedido #{$pedido->id} no valor de R$ {$pedido->valor}\n";
    }
}
