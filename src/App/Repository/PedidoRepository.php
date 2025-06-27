<?php

namespace App\Repository;

use PDO;
use App\DTO\PedidoDTO;
use App\Cache\CacheInterface;

class PedidoRepository
{
    public function __construct(
        private PDO $pdo,
        private CacheInterface $cache
    ) {}

    public function salvar(PedidoDTO $pedido): void
{
    try {
        $stmt = $this->pdo->prepare("INSERT INTO pedidos (id, cliente, descricao, valor) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pedido->id, $pedido->cliente, $pedido->descricao, $pedido->valor]);

        $this->cache->salvar($pedido);
    } catch (\PDOException $e) {
        throw new \RuntimeException('Erro ao salvar pedido no banco: ' . $e->getMessage());
    }
}

}
