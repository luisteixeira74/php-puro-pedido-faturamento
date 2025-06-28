<?php

require 'vendor/autoload.php';

use App\DTO\PedidoDTO;
use Infra\Cache\RedisCacheService;
use App\Repository\PedidoRepository;
use App\Integration\CRMIntegratorService;
use App\Integration\FaturamentoIntegratorService;
use App\Integration\IntegradorMultiploService;

try {
   // Conexão MySQL
    $pdo = new PDO(
        "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_DATABASE') . ";charset=utf8mb4",
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!class_exists('Redis')) {
        die('The Redis extension is not installed or enabled. Please install/enable it in your PHP environment.');
    }

    $redis = new Redis();
    $host = getenv('REDIS_HOST') ?: 'redis';
    $redis->connect($host, 6379);

    // Cria o serviço de cache
    $cacheService = new RedisCacheService($redis);

    // Repository com cache e PDO
    $repo = new PedidoRepository($pdo, $cacheService);

    // Novo pedido DTO
    $pedidoDTO = new PedidoDTO(101, 'José da Silva', 'Novo pedido', 200.00);

    // Converte para Entity antes de usar no domínio
    $pedidoEntity = new Domain\Entity\Pedido(
        $pedidoDTO->id,
        $pedidoDTO->cliente,
        $pedidoDTO->descricao,
        $pedidoDTO->valor
    );

    $pedidoEntity->aplicarDesconto(10); // Aplica 10% de desconto antes de salvar

    // Serviço orquestrador com integrações e repo
    $servico = new IntegradorMultiploService(
        [new CRMIntegratorService(), new FaturamentoIntegratorService()],
        $repo
    );

    $servico->integrarTudo($pedidoEntity);
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

