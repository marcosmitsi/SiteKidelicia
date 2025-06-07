<?php
require_once 'includes/auth.php';
$title = "Listar Pedidos";
require_once 'includes/header.php';

// Requisição cURL para a API
$url = "http://localhost/kidelicia/public/api/pedidos";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$pedidos = json_decode($response, true);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Lista de Pedidos</h1>
    <a href="criar_pedido.php" class="btn btn-success">+ Novo Pedido</a>
</div>

<?php if (is_array($pedidos)): ?>
    <div class="table-responsive">
        <table id="tabelaPedidos" class="table table-bordered table-hover table-striped bg-white shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>#ID</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Total (R$)</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= htmlspecialchars($pedido['id']) ?></td>
                        <td><?= htmlspecialchars($pedido['nome_cliente'] ?? 'Desconhecido') ?></td>
                        <td><?= htmlspecialchars($pedido['status_pedido'] ?? 'pendente') ?></td>
                        <td><?= number_format($pedido['total'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($pedido['criado_em']) ?></td>
                        <td>
                            <a href="visualizar_pedido.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-primary">Ver</a>
                            <a href="editar_pedido.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="deletar_pedido.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir este pedido?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Nenhum pedido encontrado.</div>
<?php endif; ?>

<!-- jQuery (necessário para o DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables + Bootstrap -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Configuração do DataTables -->
<script>
    $(document).ready(function() {
        $('#tabelaPedidos').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            }
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>
