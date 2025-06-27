<?php

namespace App\Integration;

use App\DTO\PedidoDTO;

class IntegradorMultiploService
{
    /**
     * @param PedidoIntegratorInterface[] $integradores
     */
    public function __construct(private array $integradores) {}

    public function integrarTudo(PedidoDTO $pedido): void
    {
        foreach ($this->integradores as $integrador) {
            $integrador->integrar($pedido);
        }
    }
}
