<?php
namespace Infra\Cache;

use Domain\Entity\Pedido;
use Domain\Cache\CacheInterface;
use \Redis;

class RedisCacheService implements CacheInterface
{
    public function __construct(private Redis $redis) {}

    public function salvar(Pedido $pedido): void
    {
        $this->redis->setex(
            "pedido:{$pedido->getId()}",
            3600,
            json_encode([
                'cliente' => $pedido->getCliente(),
                'descricao' => $pedido->getDescricao(),
                'valor' => $pedido->getValor(),
                'desconto_aplicado' => $pedido->isDescontoAplicado(),
            ])
        );
    }

    public function buscar(int $id): ?Pedido
    {
        $cached = $this->redis->get("pedido:$id");
        if ($cached) {
            $data = json_decode($cached, true);
            $pedido = new Pedido(
                $id,
                $data['cliente'],
                $data['descricao'],
                (float) $data['valor']
            );

            if (!empty($data['desconto_aplicado'])) {
                $pedido->aplicarDesconto(0); // você pode criar um método setDescontoAplicado(bool) se quiser evitar aplicar novamente
            }

            return $pedido;
        }
        return null;
    }
}
