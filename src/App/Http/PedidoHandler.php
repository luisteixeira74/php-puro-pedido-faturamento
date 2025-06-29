<?php
namespace App\Http;

use App\Integration\CRMIntegratorService;
use App\Integration\FaturamentoIntegratorService;
use App\Integration\IntegradorMultiploService;
use App\Repository\PedidoRepository;
use Domain\Entity\Pedido;
use App\DTO\PedidoResponseDTO;

class PedidoHandler
{
    public function __construct(private PedidoRepository $repo) {}

    public function criarPedido(): void
    {
        try {
            // Dados simulados
            $pedido = new Pedido(
                0,
                'Cliente de Teste',
                'Pedido de simulação via rota POST',
                550.00
            );

            // Aplica desconto de 10%
            $pedido->aplicarDesconto(10);

            // Integração (orquestrador)
            $servico = new IntegradorMultiploService(
                [new CRMIntegratorService(), new FaturamentoIntegratorService()],
                $this->repo
            );

            $servico->integrarTudo($pedido);

            // Retorno de sucesso
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode(PedidoResponseDTO::fromEntity($pedido));
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


    public function buscarPedidoPorId(int $id): void
    {
        $pedido = $this->repo->buscarPorId($id);
        if (!$pedido) {
            http_response_code(404);
            echo json_encode(['error' => 'Pedido não encontrado']);
            return;
        }

        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(PedidoResponseDTO::fromEntity($pedido));
    }

    public function buscarTodosPedidos(): void
    {
        $pedidos = $this->repo->buscarTodos();
        if (empty($pedidos)) {
            http_response_code(404);
            echo json_encode(['error' => 'Nenhum pedido encontrado']);
            return;
        }

        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(PedidoResponseDTO::collection($pedidos));
    }
}
