<?php
require_once 'includes/auth.php';
$title = "Novo Produto";
require_once 'includes/header.php';
require_once 'includes/api.php';

$mensagem = "";
$erro = "";

// Verifica envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nome'      => trim($_POST['nome'] ?? ''),
        'descricao' => trim($_POST['descricao'] ?? ''),
        'preco'     => floatval($_POST['preco'] ?? 0),
        'estoque'   => intval($_POST['estoque'] ?? 0)
    ];

    $response = apiRequest('/produtos', 'POST', $data);

    if (isset($response['mensagem'])) {
        $mensagem = $response['mensagem'];
    } elseif (isset($response['erro'])) {
        $erro = $response['erro'];
    } else {
        $erro = "Erro inesperado ao tentar cadastrar o produto.";
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Cadastrar Novo Produto</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
    <?php elseif ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <div class="col-md-6">
            <label for="preco" class="form-label">Preço (R$)</label>
            <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
        </div>

        <div class="col-12">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3" maxlength="100"></textarea>
        </div>

        <div class="col-md-6">
            <label for="estoque" class="form-label">Estoque</label>
            <input type="number" class="form-control" id="estoque" name="estoque" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Salvar Produto</button>
            <a href="produtos.php" class="btn btn-secondary ms-2">Voltar</a>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
