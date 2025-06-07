<?php
require_once 'includes/auth.php';
$title = "Visualizar Pedido";
require_once 'includes/header.php';


$pedidoId = $_GET['id'] ?? null;

if (!$pedidoId) {
    echo "<div class='alert alert-danger'>ID do pedido não informado.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Requisição à API
$url = "http://localhost/kidelicia/public/api/pedidos/visualizar/$pedidoId";
$response = file_get_contents($url);
$pedido = $response ? json_decode($response, true) : null;
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Pedido #<?= htmlspecialchars($pedido['id'] ?? 'Não encontrado') ?></h2>
        <a href="listar_pedidos.php" class="btn btn-secondary">← Voltar</a>
    </div>

    <?php if ($pedido): ?>
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido['nome_cliente']) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($pedido['status_pedido']) ?></p>
                <p><strong>Data:</strong> <?= htmlspecialchars($pedido['criado_em']) ?></p>
                <p><strong>Total:</strong> R$ <?= number_format((float)$pedido['total'], 2, ',', '.') ?></p>
            </div>
        </div>

        <h5>Itens do Pedido</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário (R$)</th>
                        <th>Subtotal (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedido['itens'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome_produto'] ?? 'Produto') ?></td>
                            <td><?= $item['quantidade'] ?></td>
                            <td><?= number_format((float)($item['preco_unitario'] ?? 0), 2, ',', '.') ?></td>
                            <td><?= number_format((float)($item['subtotal'] ?? 0), 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="3" class="text-end">Total</th>
                        <th>R$ <?= number_format((float)$pedido['total'], 2, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Pedido não encontrado.</div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
