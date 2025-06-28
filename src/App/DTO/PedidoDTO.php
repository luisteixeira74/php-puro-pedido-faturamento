<?php
namespace App\DTO;

class PedidoDTO
{
    public int $id;
    public string $cliente;
    public string $descricao;
    public float $valor;
    public bool $descontoAplicado;

    public function __construct(int $id, string $cliente, string $descricao, float $valor, bool $descontoAplicado = false)
    {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->descricao = $descricao;
        $this->valor = $valor;
        $this->descontoAplicado = $descontoAplicado;
    }
}
