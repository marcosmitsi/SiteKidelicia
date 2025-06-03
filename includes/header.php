<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'KiDelicia' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body style="background-color: #fff5f8;">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ffd3dc;">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="index.php">KiDelicia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="listar_pedidos.php">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="clientes_listar.php">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
