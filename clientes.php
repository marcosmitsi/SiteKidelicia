<?php
$title = "Cadastro de Cliente";
require_once 'includes/header.php';
require_once 'includes/api.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'endereco' => $_POST['endereco']
    ];

    $response = apiRequest('/clientes', 'POST', $data);

    if (isset($response['mensagem'])) {
        $mensagem = '<div class="alert alert-success">' . $response['mensagem'] . '</div>';
    } elseif (isset($response['erro'])) {
        $mensagem = '<div class="alert alert-danger">' . $response['erro'] . '</div>';
    } else {
        $mensagem = '<div class="alert alert-warning">Erro desconhecido na resposta da API.</div>';
    }
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Cadastro de Cliente</h2>
        <a href="clientes_listar.php" class="btn btn-secondary">← Voltar</a>
    </div>

    <?= $mensagem ?>

    <form method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" name="telefone" id="telefone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="endereco" class="form-label">Endereço</label>
            <input type="text" name="endereco" id="endereco" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Cadastrar Cliente</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
