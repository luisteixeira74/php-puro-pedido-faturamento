<?php

use PHPUnit\Framework\TestCase;
use Infra\Cache\RedisCacheService;
use Domain\Entity\Pedido;

class RedisCacheServiceTest extends TestCase
{
    private \Redis $redis;
    private RedisCacheService $cache;

    protected function setUp(): void
    {
        if (!class_exists(\Redis::class)) {
            $this->markTestSkipped('Extensão PHP Redis não está instalada');
        }

        $this->redis = new \Redis();

        try {
            $this->redis->connect('redis', 6379); // usar nome do container docker
        } catch (\ErrorException $e) {
            $this->markTestSkipped('Não foi possível conectar ao Redis: ' . $e->getMessage());
        }

        $this->redis->flushAll();
        $this->cache = new RedisCacheService($this->redis);
    }

    public function testSalvarEBuscarPedidoDoCache(): void
    {
        $pedido = new Pedido(101, 'João', 'Teste pedido', 199.99);
        $this->cache->salvar($pedido);

        $resultado = $this->cache->buscar(101);

        $this->assertInstanceOf(Pedido::class, $resultado);
        $this->assertEquals($pedido->getId(), $resultado->getId());
        $this->assertEquals($pedido->getCliente(), $resultado->getCliente());
        $this->assertEquals($pedido->getDescricao(), $resultado->getDescricao());
        $this->assertEquals($pedido->getValor(), $resultado->getValor());
    }

    public function testBuscaDoCache(): void
    {
        $pedido = new Pedido(999, 'Cliente Cache', 'Do cache', 99.99);
        $this->cache->salvar($pedido);

        $resultado = $this->cache->buscar(999);

        $this->assertNotNull($resultado);
        $this->assertEquals($pedido->getId(), $resultado->getId());
        $this->assertEquals($pedido->getDescricao(), $resultado->getDescricao());
    }
}
