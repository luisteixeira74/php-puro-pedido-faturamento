<?php

namespace App\Integration;

use App\DTO\PedidoDTO;

interface PedidoIntegratorInterface
{
    public function integrar(PedidoDTO $pedido): void;
}
