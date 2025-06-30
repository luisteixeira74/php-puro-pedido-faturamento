<?php

namespace App\Repository;

use PDO;
use Domain\Entity\Pedido;
use Domain\Cache\CacheInterface;

class PedidoRepository
{
    public function __construct(
        private PDO $pdo,
        private CacheInterface $cache
    ) {}
    
    /**
     * @param \Domain\Entity\Pedido $pedido
     */
    public function salvar(Pedido $pedido): void
    {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO pedidos (cliente, descricao, valor, desconto_aplicado) VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([
                $pedido->getCliente(),
                $pedido->getDescricao(),
                $pedido->getValor(),
                $pedido->isDescontoAplicado() ? 1 : 0,
            ]);

            $this->cache->salvar($pedido);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Erro ao salvar pedido no banco: ' . $e->getMessage());
        }
    }

     public function buscarPorId(int $id): ?Pedido
    {
        $pedido = $this->cache->buscar($id);
        if ($pedido !== null) {
            error_log("[CACHE] Pedido carregado do cache\n");
            return $pedido;
        }

        $stmt = $this->pdo->prepare("SELECT * FROM pedidos WHERE id = ?");
        $stmt->execute([$id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        $pedido = new Pedido(
            (int) $dados['id'],
            $dados['cliente'],
            $dados['descricao'],
            (float) $dados['valor'],
            (bool) $dados['desconto_aplicado']
        );

        // Salva no cache após buscar do banco
        $this->cache->salvar($pedido);

        return $pedido;
    }

    public function buscarTodos(): array
    {
        $stmt = $this->pdo->query("SELECT id, cliente, descricao, valor, desconto_aplicado  FROM pedidos");
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($pedidos)) {
            return [];
        }

        $resultados = [];
        foreach ($pedidos as $dados) {
            $pedido = new Pedido(
                (int) $dados['id'],
                $dados['cliente'],
                $dados['descricao'],
                (float) $dados['valor'],
                (bool) $dados['desconto_aplicado']
            );
            $resultados[] = $pedido;

            // Salva no cache após buscar do banco
            $this->cache->salvar($pedido);
        }

        return $resultados;
    }
}