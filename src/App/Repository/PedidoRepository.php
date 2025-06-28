<?php

namespace App\Repository;

use PDO;
use Domain\Entity\Pedido;
use App\Cache\CacheInterface;

class PedidoRepository
{
    public function __construct(
        private PDO $pdo,
        private CacheInterface $cache
    ) {}

    public function salvar(Pedido $pedido): void {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO pedidos (cliente, descricao, valor) VALUES (?, ?, ?)");
            $stmt->execute([$pedido->getCliente(), $pedido->getDescricao(), 
                $pedido->getValor()]);

            $this->cache->salvar($pedido);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Erro ao salvar pedido no banco: ' . $e->getMessage());
        }
    }

    public function buscar(int $id): ?Pedido {
        $pedido = $this->cache->buscar($id);
        if ($pedido !== null) {
            echo "[CACHE] Pedido carregado do cache\n";
            return $pedido;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        $pedido = new Pedido(
            id: (int) $dados['id'],
            cliente: $dados['cliente'],
            descricao: $dados['descricao'],
            valor: (float) $dados['valor']
        );

        $this->cache->salvar($pedido);

        return $pedido;
    }
}
