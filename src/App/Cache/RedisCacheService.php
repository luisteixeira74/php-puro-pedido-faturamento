<?php

namespace App\Cache;

use Redis;
use App\DTO\PedidoDTO;

class RedisCacheService implements CacheInterface
{
    public function __construct(private Redis $redis) {}

    public function salvar(PedidoDTO $pedido): void
    {
        $this->redis->setex("pedido:{$pedido->id}", 3600, json_encode([
            'cliente' => $pedido->cliente,
            'valor' => $pedido->valor,
        ]));
    }

    public function buscar(int $id): ?PedidoDTO
    {
        $cached = $this->redis->get("pedido:$id");
        if ($cached) {
            $data = json_decode($cached, true);
            return new PedidoDTO($id, $data['cliente'], $data['valor']);
        }
        return null;
    }
}
