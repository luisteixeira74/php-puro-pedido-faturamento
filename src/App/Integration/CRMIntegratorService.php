<?php

namespace App\Integration;

use App\DTO\PedidoDTO;

class CRMIntegratorService implements PedidoIntegratorInterface
{
    public function integrar(PedidoDTO $pedido): void
    {
        echo "[CRM] Registrando cliente {$pedido->cliente} no CRM\n";
    }
}
