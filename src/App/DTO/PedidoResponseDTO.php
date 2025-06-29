<?php

namespace App\DTO;

use Domain\Entity\Pedido;

class PedidoResponseDTO
{
    public static function fromEntity(Pedido $pedido): array
    {
        return [
            'id' => $pedido->getId(),
            'cliente' => $pedido->getCliente(),
            'descricaoo' => $pedido->getDescricao(),
            'valor' => $pedido->getValor(),
            'desconto_aplicado' => $pedido->isDescontoAplicado()
        ];
    }

    /**
     * Transforma uma lista de pedidos em uma lista de arrays
     */
    public static function collection(array $pedidos): array
    {
        return array_map(fn($pedido) => self::fromEntity($pedido), $pedidos);
    }
}
