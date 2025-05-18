<?php
// Incluímos o arquivo api.php onde está a função apiRequest()
// Essa função será usada para fazer a requisição GET para a API
require_once 'includes/api.php';

// Chamamos a API na rota /clientes usando método GET para buscar todos os clientes
$clientes = apiRequest('/clientes');

// Agora o array $clientes contém todos os dados que vieram da API
?>
<!DOCTYPE html>
<html>

<head>
    <title>Listar Clientes - KiDelicia</title>
    <style>
        /* Estilizando a tabela para ficar mais legível */
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Lista de Clientes Cadastrados</h1>

    <!-- Aqui verificamos se vieram clientes da API -->
    <?php if (is_array($clientes) && count($clientes) > 0): ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Criado em</th>
                </tr>
            </thead>
            <tbody>
                <!-- Usamos um loop para percorrer cada cliente e exibir na tabela -->
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['id']) ?></td>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                        <td><?= htmlspecialchars($cliente['endereco']) ?></td>
                        <td><?= htmlspecialchars($cliente['criado_em']) ?></td>

                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <!-- Caso não tenha clientes, mostramos uma mensagem -->
    <?php else: ?>
        <p style="text-align: center; color: red;">Nenhum cliente cadastrado.</p>
    <?php endif; ?>
</body>

</html>