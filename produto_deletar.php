<?php
require_once 'includes/auth.php';
$title = "Deletar Produto";
require_once 'includes/header.php';
require_once 'includes/api.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='alert alert-danger'>ID do produto não informado.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Requisição para deletar produto
$resposta = apiRequest("/produtos/$id", 'DELETE');

?>

<div class="container mt-5">
    <?php if (isset($resposta['mensagem'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($resposta['mensagem']) ?>
        </div>
        <a href="produtos.php" class="btn btn-success">Voltar à Lista de Produtos</a>
    <?php else: ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($resposta['erro'] ?? 'Erro ao excluir produto.') ?>
        </div>
        <a href="produtos.php" class="btn btn-secondary">Voltar</a>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>
