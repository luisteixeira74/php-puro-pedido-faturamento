<?php

namespace App\Cache;

use App\DTO\PedidoDTO;

interface CacheInterface
{
    public function salvar(PedidoDTO $pedido): void;
    public function buscar(int $id): ?PedidoDTO;
}
