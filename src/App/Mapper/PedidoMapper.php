<?php
namespace App\Mapper;

use App\DTO\PedidoRequestDTO;
use Domain\Entity\Pedido;

class PedidoMapper
{
    public static function fromRequestDTO(PedidoRequestDTO $dto): Pedido
    {
        return new Pedido(
            0,
            $dto->cliente,
            $dto->descricao,
            $dto->valor
        );
    }
}
