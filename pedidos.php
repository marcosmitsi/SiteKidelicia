<?php
// Incluímos o arquivo onde está a função apiRequest()
require_once 'includes/api.php';

// Chamamos a API para buscar os clientes
$clientes = apiRequest('/clientes');

// Chamamos a API para buscar os produtos

$produtos = apiRequest('/produtos');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Pedido - KiDelicia</title>
</head>
<body>
   <h1>Novo Pedido</h1>

    <h2>Clientes disponíveis:</h2> 

    <ul>
        <?php foreach ($clientes as $cliente): ?>
        <li><?= $cliente['id']?> - <?=$cliente['nome'] ?></li>
        <?php endforeach;?>
    </ul>

    <h2>Produtos disponíveis:</h2>
    <ul>
        <?php foreach ($produtos as $produto): ?>
        <li>
            <li><?= $produto['id'] ?> - <?= $produto['nome'] ?> (R$ <?= number_format($produto['preco'], 2, ',', '.') ?>)</li>
        </li>
         <?php endforeach; ?>
    </ul>
    
</body>
</html>