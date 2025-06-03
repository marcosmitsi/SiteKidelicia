<?php
$title = "Listar Clientes";
require_once 'includes/header.php';

// Requisição para buscar os clientes via API
$url = "http://localhost/kidelicia/public/api/clientes";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$clientes = json_decode($response, true);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">Lista de Clientes</h1>
        <a href="clientes.php" class="btn btn-success">+ Novo Cliente</a>
    </div>

    <?php if (is_array($clientes)): ?>
        <div class="table-responsive">
            <table id="tabelaClientes" class="table table-bordered table-hover table-striped bg-white shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th>Ações</th>
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
                            <td>
                                <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="deletar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir este cliente?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Nenhum cliente encontrado.</div>
    <?php endif; ?>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabelaClientes').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            responsive: true
        });
    });
</script>

<?php require_once 'includes/footer.php'; ?>
