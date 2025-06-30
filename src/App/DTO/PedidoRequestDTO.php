<?php
namespace App\DTO;

class PedidoRequestDTO
{
    public string $cliente;
    public string $descricao;
    public float $valor;

    public function __construct(string $cliente, string $descricao, float $valor) {
        $this->cliente = $cliente;
        $this->descricao = $descricao;
        $this->valor = $valor;
    }
}
