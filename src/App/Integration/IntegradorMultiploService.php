<?php

namespace App\Integration;

use App\DTO\PedidoDTO;
use App\Repository\PedidoRepository;

class IntegradorMultiploService
{
    /**
     * @param PedidoIntegratorInterface[] $integradores
     */
    public function __construct(
        private array $integradores,
        private PedidoRepository $repository
    ) {}

    public function integrarTudo(PedidoDTO $pedido): void
    {
        foreach ($this->integradores as $integrador) {
            $integrador->integrar($pedido);
        }

        // Agora sim, salvando no banco ao final
        $this->repository->salvar($pedido);
    }
}
