<?php
require_once 'includes/auth.php';
// Verifica se o ID foi passado via GET
$pedidoId = $_GET['id'] ?? null;

if (!$pedidoId) {
    echo "ID do pedido não informado.";
    exit;
}

// URL da API para excluir o pedido
$url = "http://localhost/kidelicia/public/api/pedidos/$pedidoId";

// Inicializa a requisição CURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Trata a resposta
if ($httpCode === 200) {
    echo "<script>alert('Pedido excluído com sucesso!'); window.location.href='listar_pedidos.php';</script>";
} else {
    $erro = json_decode($response, true);
    $mensagem = $erro['erro'] ?? 'Erro ao excluir o pedido.';
    echo "<script>alert('Erro: {$mensagem}'); window.location.href='listar_pedidos.php';</script>";
}
?>
