<?php
namespace App\Domain\Repository;

use Domain\Entity\Pedido;

interface PedidoRepositoryInterface {
    public function salvar(Pedido $pedido): void;
    public function buscar(int $id): ?Pedido;
}
