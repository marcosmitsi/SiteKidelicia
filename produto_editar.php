<?php
require_once 'includes/auth.php';
$title = "Editar Produto";
require_once 'includes/header.php';
require_once 'includes/api.php';

$id = $_GET['id'] ?? null;
$mensagem = "";
$erro = "";

if (!$id) {
    echo "<div class='alert alert-danger'>ID do produto não informado.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Buscar produto pela API
$produto = apiRequest("/produtos/$id", 'GET');
if (!$produto || isset($produto['erro'])) {
    echo "<div class='alert alert-danger'>Produto não encontrado.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Processar atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nome'      => trim($_POST['nome']),
        'descricao' => trim($_POST['descricao']),
        'preco'     => floatval($_POST['preco']),
        'estoque'   => intval($_POST['estoque'])
    ];

    $resposta = apiRequest("/produtos/$id", 'PUT', $data);

    if (isset($resposta['mensagem'])) {
        $mensagem = $resposta['mensagem'];
        $produto = array_merge($produto, $data); // Atualiza dados exibidos no formulário
    } else {
        $erro = $resposta['erro'] ?? 'Erro ao atualizar produto.';
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Editar Produto #<?= htmlspecialchars($id) ?></h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
    <?php elseif ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
        </div>

        <div class="col-md-6">
            <label for="preco" class="form-label">Preço (R$)</label>
            <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>
        </div>

        <div class="col-12">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
        </div>

        <div class="col-md-6">
            <label for="estoque" class="form-label">Estoque</label>
            <input type="number" class="form-control" id="estoque" name="estoque" value="<?= htmlspecialchars($produto['estoque']) ?>" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="produtos.php" class="btn btn-secondary ms-2">Voltar</a>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
