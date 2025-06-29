<?php

namespace App\Integration;

use Domain\Entity\Pedido;

class CRMIntegratorService implements PedidoIntegratorInterface
{
    public function integrar(Pedido $pedido): void
    {
        error_log("[CRM] Registrando cliente {$pedido->getCliente()} no CRM\n");
    }
}
