<?php
namespace Domain\Entity;

class Pedido
{
    private int $id;
    private string $cliente;
    private string $descricao;
    private float $valor;
    private bool $descontoAplicado = false;

    public function __construct(int $id, string $cliente, string $descricao, float $valor)
    {
        if ($valor <= 0) {
            throw new \InvalidArgumentException("O valor do pedido deve ser maior que zero");
        }

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

    public function isDescontoAplicado(): bool
    {
        return $this->descontoAplicado;
    }

    public function aplicarDesconto(float $percentual): void
    {
        if ($this->descontoAplicado) {
            throw new \LogicException("Desconto já foi aplicado a este pedido");
        }

        if ($percentual < 0 || $percentual > 100) {
            throw new \InvalidArgumentException("Percentual inválido para desconto");
        }

        $this->valor = $this->valor * (1 - $percentual / 100);
        $this->descontoAplicado = true;
    }
}
