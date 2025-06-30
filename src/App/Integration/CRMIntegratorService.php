<?php

namespace App\Integration;

use Domain\Entity\Pedido;
use Domain\Log\LoggerInterface;

class CRMIntegratorService implements PedidoIntegratorInterface
{
    public function __construct(private LoggerInterface $logger) {}

    public function integrar(Pedido $pedido): void
    {
        $this->logger->log("[CRM] Registrando cliente {$pedido->getCliente()} no CRM\n");
    }
}
