<?php

namespace Domain\Cache;

use Domain\Entity\Pedido;

interface CacheInterface
{
    public function salvar(Pedido $pedido): void;
    public function buscar(int $id): ?Pedido;
}
