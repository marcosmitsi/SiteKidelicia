<?php
require_once 'includes/auth.php';
$title = "Painel KiDelicia";
require_once 'includes/header.php';

// ======== Buscar dados da API ========
function buscarAPI($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

$pedidos = buscarAPI('http://localhost/kidelicia/public/api/pedidos');
$clientes = buscarAPI('http://localhost/kidelicia/public/api/clientes');
$produtos = buscarAPI('http://localhost/kidelicia/public/api/produtos');

// Totais e Faturamento
$totalPedidos = is_array($pedidos) ? count($pedidos) : 0;
$totalClientes = is_array($clientes) ? count($clientes) : 0;
$totalProdutos = is_array($produtos) ? count($produtos) : 0;

$faturamento = 0;
$totaisPorMes = [];

if (is_array($pedidos)) {
    foreach ($pedidos as $pedido) {
        $faturamento += floatval($pedido['total']);
        $mes = date('Y-m', strtotime($pedido['criado_em']));
        $totaisPorMes[$mes] = ($totaisPorMes[$mes] ?? 0) + floatval($pedido['total']);
    }
    ksort($totaisPorMes);
}
?>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="bg-white rounded shadow-sm p-4 border text-center">
            <h6 class="text-muted">Total de Pedidos</h6>
            <h3 class="text-primary"><?= $totalPedidos ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white rounded shadow-sm p-4 border text-center">
            <h6 class="text-muted">Clientes</h6>
            <h3 class="text-success"><?= $totalClientes ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white rounded shadow-sm p-4 border text-center">
            <h6 class="text-muted">Produtos</h6>
            <h3 class="text-warning"><?= $totalProdutos ?></h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-white rounded shadow-sm p-4 border text-center">
            <h6 class="text-muted">Faturamento Total</h6>
            <h3 class="text-danger">R$ <?= number_format($faturamento, 2, ',', '.') ?></h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="bg-white rounded shadow-sm p-4 border">
            <h2 class="h5 text-center mb-4">Total de Vendas por Mês</h2>
            <canvas id="graficoVendas" height="100"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoVendas').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode(array_keys($totaisPorMes)) ?>,
        datasets: [{
            label: 'Total de Vendas (R$)',
            data: <?= json_encode(array_values($totaisPorMes)) ?>,
            fill: true,
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            borderColor: 'rgba(255, 99, 132, 1)',
            tension: 0.3,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            tooltip: {
                callbacks: {
                    label: ctx => 'R$ ' + parseFloat(ctx.raw).toFixed(2).replace('.', ',')
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => 'R$ ' + value.toFixed(2).replace('.', ',')
                }
            }
        }
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
