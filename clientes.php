<?php
// Importa (apenas uma vez) a função apiRequest() que faz a chamada cURL
require_once 'includes/api.php';

//usuário clicou no botão “Cadastrar Cliente” o bloco abaixo monta os dados,chama a API e exibe a mensagem de resultado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cria um array associativo com os campos recebidos do formulário
    $data = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'telefone' => $_POST['telefone'],
        'endereco' => $_POST['endereco']

    ];
    // Envia os dados para a API (POST /clientes) e recebe resposta em array
    $response = apiRequest('/clientes', 'POST', $data);
    // Interpreta a resposta da API e mostra feedback ao usuário
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