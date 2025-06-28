<?php

use PHPUnit\Framework\TestCase;
use Infra\Cache\RedisCacheService;
use App\DTO\PedidoDTO;

class RedisCacheServiceTest extends TestCase
{
    private \Redis $redis;
    private RedisCacheService $cache;

    protected function setUp(): void
    {
        $this->redis = new Redis();
        $this->redis->connect('localhost', 6379);
        $this->redis->flushAll(); // Limpa tudo antes de cada teste

        $this->cache = new RedisCacheService($this->redis);
    }

    public function testSalvarEBuscarPedidoDoCache(): void
    {
        $pedidoDTO = new PedidoDTO(101, 'João', 'Teste pedido', 199.99);

        // Converte para Entity antes de usar no domínio
        $pedidoEntity = new Domain\Entity\Pedido(
            $pedidoDTO->id,
            $pedidoDTO->cliente,
            $pedidoDTO->descricao,
            $pedidoDTO->valor
        );

        // Salva no cache
        $this->cache->salvar($pedidoEntity);

        // Recupera
        $resultado = $this->cache->buscar(101);

        $this->assertInstanceOf(PedidoDTO::class, $resultado);
        $this->assertEquals($pedidoEntity->getId(), $resultado->getId());
        $this->assertEquals($pedidoEntity->getCliente(), $resultado->getCliente());
        $this->assertEquals($pedidoEntity->getDescricao(), $resultado->getDescricao());
        $this->assertEquals($pedidoEntity->getValor(), $resultado->getValor());
    }

    public function testBuscaDoCache() {
        $redis = new Redis();
        $redis->connect('redis', 6379);
        $cache = new RedisCacheService($redis);

        $pedidoDTO = new PedidoDTO(999, 'Cliente Cache', 'Do cache', 99.99);

        // Converte para Entity antes de usar no domínio
        $pedidoEntity = new Domain\Entity\Pedido(
            $pedidoDTO->id,
            $pedidoDTO->cliente,
            $pedidoDTO->descricao,
            $pedidoDTO->valor
        );

        $cache->salvar($pedidoEntity);

        $resultado = $cache->buscar(999);

        $this->assertNotNull($resultado);
        $this->assertEquals($pedidoEntity->getId(), $resultado->getId());
        $this->assertEquals($pedidoEntity->getDescricao(), $resultado->getDescricao());
    }

}
