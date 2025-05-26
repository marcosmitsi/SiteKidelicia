<?php

require_once 'includes/api.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $data = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'endereco' => $_POST['endereco']

    ];
   
    $response = apiRequest('/clientes', 'POST', $data);

    if (isset($response['mensagem'])) {
        echo "<p>{$response['mensagem']}</p>";
    } elseif (isset($response['erro'])) {
        echo "<p style='color:red;'>{$response['erro']}</p>";
    } else {
        echo "<p>Erro desconhecido na resposta da API.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Cliente</title>
</head>

<body>
    <form method="POST">
        Nome: <input type="text" name="nome"><br>
        Email: <input type="email" name="email"><br>
        Telefone: <input type="text" name="telefone"><br>
        Endereço: <input type="text" name="endereco"><br>
        <button type="submit">Cadastrar Cliente</button>
    </form>

</body>

</html>