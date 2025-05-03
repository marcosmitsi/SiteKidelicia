<?php require_once 'includes/api.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiDelicia - Produtos</title>
</head>
<body>
    <h1>Produtos disponíveis</h1>
    <ul>
        <?php
        $produtos = apiRequest('/produtos');
        foreach($produtos as $produto){
            echo"<li>{$produto['nome']} - R$ {$produto['preco']}</li>";
        }

        ?>
    </ul>
</body>
</html>