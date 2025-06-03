<?php
$title = "Início";
require_once 'includes/header.php';
?>

<div class="text-center mt-5">
    <h1 class="mb-4">Bem-vindo ao Sistema KiDelicia</h1>
    <p class="lead">Escolha uma das opções abaixo para começar:</p>

    <div class="row justify-content-center mt-4">
        
        <div class="col-md-3">
            <a href="listar_pedidos.php" class="btn btn-lg btn-outline-primary w-100 mb-3">Pedidos</a>
        </div>
        <div class="col-md-3">
            <a href="clientes.php" class="btn btn-lg btn-outline-success w-100 mb-3">Clientes</a>
        </div>
        <div class="col-md-3">
            <a href="produtos.php" class="btn btn-lg btn-outline-warning w-100 mb-3">Produtos</a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
