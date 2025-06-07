<?php
require_once 'includes/auth.php';
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: listar_clientes.php?erro=ID não informado");
    exit;
}

// Requisição DELETE
$url = "http://localhost/kidelicia/public/api/clientes/$id";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);
$resultado = json_decode($response, true);

// Redireciona com mensagem
if (isset($resultado['mensagem'])) {
    header("Location: clientes_listar.php?msg=" . urlencode($resultado['mensagem']));
} else {
    header("Location: clientes_listar.php.php?erro=" . urlencode($resultado['erro'] ?? 'Erro ao excluir'));
}
exit;
