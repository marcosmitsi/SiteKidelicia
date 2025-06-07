<?php
require_once 'includes/auth.php';
$title = "Criar Pedido";
require_once 'includes/header.php';

// Busca clientes
$clientesUrl = 'http://localhost/kidelicia/public/api/clientes';
$ch = curl_init($clientesUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$clientes = $response ? json_decode($response, true) : [];

// Busca produtos
$produtosUrl = 'http://localhost/kidelicia/public/api/produtos';
$ch = curl_init($produtosUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$produtos = $response ? json_decode($response, true) : [];
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Criar Novo Pedido</h2>
        <a href="listar_pedidos.php" class="btn btn-secondary">← Voltar</a>
    </div>

    <form id="pedidoForm">
        <div class="mb-3">
            <label for="cliente_id" class="form-label">Cliente</label>
            <select class="form-select" id="cliente_id" name="cliente_id" required>
                <option value="">Selecione um cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <h5>Itens do Pedido</h5>
        <div id="itensContainer">
            <div class="row mb-3 item-pedido">
                <div class="col-md-6">
                    <select class="form-select" name="produto_id[]" required>
                        <option value="">Selecione um produto</option>
                        <?php foreach ($produtos as $produto): ?>
                            <option value="<?= $produto['id'] ?>">
                                <?= htmlspecialchars($produto['nome']) ?> (R$ <?= number_format($produto['preco'], 2, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" name="quantidade[]" placeholder="Quantidade" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm removerItem">Remover</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-outline-primary mb-3" id="adicionarItem">+ Adicionar Item</button><br>
        <button type="submit" class="btn btn-success">Salvar Pedido</button>
    </form>

    <div id="mensagem" class="mt-4"></div>
</div>

<script>
const produtos = <?= json_encode($produtos) ?>;

document.getElementById('adicionarItem').addEventListener('click', function () {
    const itemHTML = `
        <div class="row mb-3 item-pedido">
            <div class="col-md-6">
                <select class="form-select" name="produto_id[]" required>
                    <option value="">Selecione um produto</option>
                    ${produtos.map(p => `<option value="${p.id}">${p.nome} (R$ ${parseFloat(p.preco).toFixed(2).replace('.', ',')})</option>`).join('')}
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="quantidade[]" placeholder="Quantidade" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm removerItem">Remover</button>
            </div>
        </div>`;
    document.getElementById('itensContainer').insertAdjacentHTML('beforeend', itemHTML);
});

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('removerItem')) {
        e.target.closest('.item-pedido').remove();
    }
});

document.getElementById('pedidoForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const clienteId = document.getElementById('cliente_id').value;
    const produtoIds = document.querySelectorAll('select[name="produto_id[]"]');
    const quantidades = document.querySelectorAll('input[name="quantidade[]"]');

    let itens = [];
    for (let i = 0; i < produtoIds.length; i++) {
        itens.push({
            produto_id: produtoIds[i].value,
            quantidade: quantidades[i].value
        });
    }

    const data = {
        cliente_id: clienteId,
        itens: itens
    };

    const resposta = await fetch('http://localhost/kidelicia/public/api/pedidos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    const resultado = await resposta.json();
    const mensagemDiv = document.getElementById('mensagem');

    if (resultado.mensagem) {
        mensagemDiv.innerHTML = `<div class="alert alert-success">${resultado.mensagem}</div>`;
        document.getElementById('pedidoForm').reset();
        document.getElementById('itensContainer').innerHTML = '';
    } else {
        mensagemDiv.innerHTML = `<div class="alert alert-danger">${resultado.erro ?? 'Erro ao salvar o pedido.'}</div>`;
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
