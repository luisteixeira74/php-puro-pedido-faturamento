<?php

require 'vendor/autoload.php';

use App\DTO\PedidoDTO;
use App\Integration\CRMIntegratorService;
use App\Integration\FaturamentoIntegratorService;
use App\Integration\IntegradorMultiploService;

$pedido = new PedidoDTO(id: 101, cliente: 'José da Silva', valor: 129.99);

$servico = new IntegradorMultiploService([
    new CRMIntegratorService(),
    new FaturamentoIntegratorService()
]);

$servico->integrarTudo($pedido);
