<?php

namespace App\Integration;

use Domain\Entity\Pedido;
use Domain\Log\LoggerInterface;

class FaturamentoIntegratorService implements PedidoIntegratorInterface
{
    public function __construct(private LoggerInterface $logger) {}

    public function integrar(Pedido $pedido): void
    {
        $valorFormatado = number_format($pedido->getValor(), 2, ',', '');
        $this->logger->log("[Faturamento] Emitindo nota para o pedido #{$pedido->getId()} no valor de R$ {$valorFormatado}\n");
    }
}