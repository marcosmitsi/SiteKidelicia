<?php
require_once 'includes/auth.php';
$title = "Editar Cliente";
require_once 'includes/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='alert alert-danger'>ID do cliente não informado.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Buscar cliente
$url = "http://localhost/kidelicia/public/api/clientes/$id";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$cliente = json_decode($response, true);

if (!$cliente || isset($cliente['erro'])) {
    echo "<div class='alert alert-danger'>Cliente não encontrado.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Atualização via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'endereco' => $_POST['endereco']
    ];

    $urlUpdate = "http://localhost/kidelicia/public/api/clientes/$id";
    $ch = curl_init($urlUpdate);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    $resultado = json_decode($response, true);

    if (isset($resultado['mensagem'])) {
        echo "<div class='alert alert-success'>{$resultado['mensagem']}</div>";
    } else {
        echo "<div class='alert alert-danger'>{$resultado['erro']}</div>";
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Editar Cliente</h2>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Endereço</label>
            <input type="text" name="endereco" class="form-control" value="<?= htmlspecialchars($cliente['endereco']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="clientes_listar.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
