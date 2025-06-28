<?php
namespace Domain\Entity;

class Pedido
{
    private int $id;
    private string $cliente;
    private string $descricao;
    private float $valor;

    public function __construct(int $id, string $cliente, string $descricao, float $valor)
    {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->descricao = $descricao;
        $this->valor = $valor;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCliente(): string
    {
        return $this->cliente;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getValor(): float
    {
        return $this->valor;
    }

    public function aplicarDesconto(float $percentual): void
    {
        if ($percentual < 0 || $percentual > 100) {
            throw new \InvalidArgumentException("Percentual inválido para desconto");
        }
        $this->valor = $this->valor * (1 - $percentual / 100);
    }
}
