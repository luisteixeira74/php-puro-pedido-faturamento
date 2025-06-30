<?php
namespace App\DTO;

class PedidoResponseDTO
{
    public int $id;
    public string $cliente;
    public string $descricao;
    public float $valor;
    public bool $desconto_aplicado;

    public function __construct(
        int $id,
        string $cliente,
        string $descricao,
        float $valor,
        bool $desconto_aplicado
    ) {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->desconto_aplicado = $desconto_aplicado;
    }

    public static function fromEntity(\Domain\Entity\Pedido $pedido): self
    {
        return new self(
            $pedido->getId(),
            $pedido->getCliente(),
            $pedido->getDescricao(),
            $pedido->getValor(),
            $pedido->isDescontoAplicado()
        );
    }

    public static function collection(array $pedidos): array
    {
        return array_map(fn($pedido) => self::fromEntity($pedido), $pedidos);
    }
}
