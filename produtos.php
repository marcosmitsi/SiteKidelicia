<?php
$title = "Produtos";
require_once 'includes/header.php';
require_once 'includes/api.php';

// Busca lista de produtos via API
$response = apiRequest('/produtos', 'GET');
$produtos = is_array($response) ? $response : [];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Lista de Produtos</h1>
    <a href="produto_criar.php" class="btn btn-success">+ Novo Produto</a>
</div>

<?php if (count($produtos) > 0): ?>
    <div class="table-responsive">
        <table id="tabela" class="table table-bordered table-hover table-striped bg-white shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço (R$)</th>
                    <th>Estoque</th>
                    <th>Ações</th>
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
                        <td>
                            <a href="produto_editar.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="produto_deletar.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir este produto?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Nenhum produto encontrado.</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
