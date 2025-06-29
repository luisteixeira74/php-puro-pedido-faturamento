<?php

require 'vendor/autoload.php';
header('Content-Type: application/json');

use Infra\Cache\RedisCacheService;
use App\Repository\PedidoRepository;
use App\Http\PedidoHandler;

try {
    $pdo = new PDO(
        "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_DATABASE') . ";charset=utf8mb4",
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"]
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!class_exists('Redis')) {
        http_response_code(500);
        echo json_encode(['error' => 'Extensão Redis não instalada.']);
        exit;
    }

    $redis = new Redis();
    $host = getenv('REDIS_HOST') ?: 'redis';
    $redis->connect($host, 6379);

    $cacheService = new RedisCacheService($redis);
    $repo = new PedidoRepository($pdo, $cacheService);
    $handler = new PedidoHandler($repo);

    $requestUri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'POST' && $requestUri === '/pedido') {
        $handler->criarPedido();
        exit;
    }

    if ($method === 'GET' && preg_match('#^/pedido/(\d+)$#', $requestUri, $matches)) {
        $handler->buscarPedidoPorId((int)$matches[1]);
        exit;
    }

    if ($method === 'GET' && $requestUri === '/pedidos') {
        $handler->buscarTodosPedidos();
        exit;
    }

    http_response_code(404);
    echo json_encode(['erro' => 'Rota não encontrada']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
