<?php
namespace App\Http;

use App\DTO\PedidoRequestDTO;
use App\DTO\PedidoResponseDTO;
use App\Integration\CRMIntegratorService;
use App\Integration\FaturamentoIntegratorService;
use App\Integration\IntegradorMultiploService;
use App\Mapper\PedidoMapper;
use App\Repository\PedidoRepository;
use Domain\Log\LoggerInterface;

class PedidoHandler
{
    public function __construct(
        private PedidoRepository $repo,
        private LoggerInterface $logger
    ) {}

    public function criarPedido(): void
    {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $dto = new PedidoRequestDTO(
                cliente: $data['cliente'] ?? '',
                descricao: $data['descricao'] ?? '',
                valor: isset($data['valor']) ? (float)$data['valor'] : 0.0
            );

            $erros = [];
            if (empty($dto->cliente)) {
                $erros[] = "Cliente é obrigatório";
            }
            if (empty($dto->descricao)) {
                $erros[] = "Descrição é obrigatória";
            }
            if ($dto->valor <= 0) {
                $erros[] = "Valor deve ser maior que zero";
            }

            if (count($erros) > 0) {
                http_response_code(400);
                echo json_encode(['errors' => $erros]);
                return;
            }

            $pedido = PedidoMapper::fromRequestDTO($dto);

            // Aplica desconto de 10%
            $pedido->aplicarDesconto(10);

            $crm = new CRMIntegratorService($this->logger);
            $faturamento = new FaturamentoIntegratorService($this->logger);

            $servico = new IntegradorMultiploService(
                [$crm, $faturamento],
                $this->repo
            );

            $servico->integrarTudo($pedido);

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
