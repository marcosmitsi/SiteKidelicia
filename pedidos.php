<?php
require_once 'includes/auth.php';
include 'includes/api.php';

$clientes = apiRequest('/clientes');
$produtos = apiRequest('/produtos');


$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cliente_id = $_POST['cliente_id'];
    $quantidades = $_POST['quantidade'];
    $itens = [];

    foreach ($quantidades as $produto_id => $quantidade) {
        if ($quantidade > 0) {
            $itens[] = [
                "produto_id" => (int) $produto_id,
                "quantidade" => (int) $quantidade
            ];
        }
    }


    $data = [
        "cliente_id" => (int) $cliente_id,
        "itens" => $itens
    ];
    $response = apiRequest('/pedidos', 'POST', $data);
    if (isset($response['mensagem'])) {
        $mensagem = "<p style='color: green;'>{$response['mensagem']} (ID do pedido: {$response['pedido_id']})</p>";
    } elseif (isset($response['erro'])) {
        $mensagem = "<p style='color: red;'>{$response['erro']}</p>";
    } else {
        $mensagem = "<p style='color: orange;'>Erro desconhecido ao enviar o pedido.</p>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Novo Pedido - KiDelicia</title>
</head>

<body>
    <h1>Novo Pedido</h1>
    <?= $mensagem ?>

    <form method="POST">
        <label for="cliente">Selecione o Cliente:</label><br>
        <select name="cliente_id" required>
            <option value="">-- Selecione --</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente['id'] ?>"><?= $cliente['nome'] ?> (<?= $cliente['email'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <h3>Produtos:</h3>
        <?php foreach ($produtos as $produto): ?>
            <div>
                <label>
                    <?= $produto['nome'] ?> (R$ <?= number_format($produto['preco'], 2, ',', '.') ?>):
                    <input type="number" name="quantidade[<?= $produto['id'] ?>]" min="0" value="0">
                </label>
            </div>
        <?php endforeach; ?>

        <br>
        <button type="submit">Enviar Pedido</button>
    </form>
</body>

</html>