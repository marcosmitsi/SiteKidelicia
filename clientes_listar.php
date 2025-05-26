<?php

require_once 'includes/api.php';


$clientes = apiRequest('/clientes');


?>
<!DOCTYPE html>
<html>

<head>
    <title>Listar Clientes - KiDelicia</title>
    <style>
       
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


    <?php else: ?>
        <p style="text-align: center; color: red;">Nenhum cliente cadastrado.</p>
    <?php endif; ?>
</body>

</html>