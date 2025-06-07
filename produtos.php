<?php
require_once 'includes/auth.php';
$title = "Produtos";
require_once 'includes/header.php';
require_once 'includes/api.php';

// Busca lista de produtos via API
$response = apiRequest('/produtos', 'GET');
$produtos = is_array($response) ? $response : [];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Lista de Produtos</h1>
    <a href="produto_criar.php" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Novo Produto
    </a>
</div>

<?php if (count($produtos) > 0): ?>
    <div class="table-responsive">
        <table id="tabelaProdutos" class="table table-bordered table-hover table-striped bg-white shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço (R$)</th>
                    <th>Estoque</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= htmlspecialchars($produto['id']) ?></td>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                        <td><?= htmlspecialchars($produto['descricao']) ?></td>
                        <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                        <td><?= (int) $produto['estoque'] ?></td>
                        <td class="text-center">
                            <a href="produto_editar.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="produto_deletar.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir este produto?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Nenhum produto encontrado.</div>
<?php endif; ?>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Ícones Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    $(document).ready(function () {
        $('#tabelaProdutos').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            responsive: true
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>
