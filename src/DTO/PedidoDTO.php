<?php

namespace App\DTO;

readonly class PedidoDTO
{
    public function __construct(
        public int $id,
        public string $cliente,
        public float $valor,
    ) {}
}