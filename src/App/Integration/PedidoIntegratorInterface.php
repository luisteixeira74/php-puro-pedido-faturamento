<?php

namespace App\Integration;

use Domain\Entity\Pedido;

interface PedidoIntegratorInterface
{
    public function integrar(Pedido $pedido): void;
}
