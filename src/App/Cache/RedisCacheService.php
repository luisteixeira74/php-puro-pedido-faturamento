<?php

namespace App\Cache;

use Redis;
use Domain\Entity\Pedido;

class RedisCacheService implements CacheInterface
{
    public function __construct(private Redis $redis) {}

    public function salvar(Pedido $pedido): void
    {
        $this->redis->setex("pedido:{$pedido->getId()}", 3600, json_encode([
            'cliente' => $pedido->getCliente(),
            'valor' => $pedido->getValor(),
        ]));
    }

    public function buscar(int $id): ?Pedido
    {
        $cached = $this->redis->get("pedido:$id");
        if ($cached) {
            $data = json_decode($cached, true);
            return new Pedido($id, $data['cliente'], $data['descricao'], $data['valor']);
        }
        return null;
    }
}
