<?php
require_once 'includes/auth.php';
$title = "Editar Pedido";
require_once 'includes/header.php';

$pedidoId = $_GET['id'] ?? null;
if (!$pedidoId) {
    echo "<div class='alert alert-danger'>ID do pedido não informado.</div>";
    require_once 'includes/footer.php';
    exit;
}

// Carrega os dados do pedido
$urlPedido = "http://localhost/kidelicia/public/api/pedidos/visualizar/$pedidoId";
$pedido = json_decode(file_get_contents($urlPedido), true);

// Carrega os produtos disponíveis
$urlProdutos = "http://localhost/kidelicia/public/api/produtos";
$produtos = json_decode(file_get_contents($urlProdutos), true);

if (!$pedido || isset($pedido['erro'])) {
    echo "<div class='alert alert-danger'>Pedido não encontrado.</div>";
    require_once 'includes/footer.php';
    exit;
}
?>

<h1 class="h4 mb-4">Editar Pedido #<?= $pedido['id'] ?></h1>

<form id="formPedido">
    <input type="hidden" name="id" value="<?= $pedido['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Cliente</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($pedido['nome_cliente']) ?>" disabled>
    </div>

    <div class="mb-3">
        <label class="form-label">Status do Pedido</label>
        <select name="status_pedido" class="form-select" required>
            <?php
            $statusDisponiveis = ['pendente', 'processando', 'concluido', 'cancelado'];
            foreach ($statusDisponiveis as $status) {
                $selected = ($status == $pedido['status_pedido']) ? 'selected' : '';
                echo "<option value=\"$status\" $selected>$status</option>";
            }
            ?>
        </select>
    </div>

    <h5>Itens do Pedido</h5>
    <table class="table" id="tabelaItens">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedido['itens'] as $item): ?>
                <tr>
                    <td>
                        <select name="produto_id[]" class="form-select">
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?= $produto['id'] ?>" <?= $produto['id'] == $item['produto_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($produto['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="quantidade[]" class="form-control" value="<?= $item['quantidade'] ?>" min="1" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removerLinha(this)">Remover</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="button" class="btn btn-secondary mb-3" onclick="adicionarLinha()">+ Adicionar Produto</button>
    <br>
    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    <a href="listar_pedidos.php" class="btn btn-secondary">Voltar</a>
</form>

<script>
const produtos = <?= json_encode($produtos) ?>;

function adicionarLinha() {
    const tbody = document.querySelector('#tabelaItens tbody');
    const linha = document.createElement('tr');
    linha.innerHTML = `
        <td>
            <select name="produto_id[]" class="form-select">
                ${produtos.map(p => `<option value="${p.id}">${p.nome}</option>`).join('')}
            </select>
        </td>
        <td>
            <input type="number" name="quantidade[]" class="form-control" value="1" min="1" required>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="removerLinha(this)">Remover</button>
        </td>`;
    tbody.appendChild(linha);
}

function removerLinha(btn) {
    btn.closest('tr').remove();
}

document.getElementById('formPedido').addEventListener('submit', async function(e) {
    e.preventDefault();

    const pedidoId = <?= $pedido['id'] ?>;
    const status = document.querySelector('[name="status_pedido"]').value;
    const produtoIds = Array.from(document.querySelectorAll('[name="produto_id[]"]')).map(p => p.value);
    const quantidades = Array.from(document.querySelectorAll('[name="quantidade[]"]')).map(q => q.value);

    const itens = produtoIds.map((id, i) => ({
        produto_id: parseInt(id),
        quantidade: parseInt(quantidades[i])
    }));

    const data = {
        cliente_id: <?= $pedido['cliente_id'] ?>,
        status_pedido: status,
        itens: itens
    };

    const resposta = await fetch(`http://localhost/kidelicia/public/api/pedidos/${pedidoId}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });

    const resultado = await resposta.json();

    if (resposta.ok) {
        alert('Pedido atualizado com sucesso!');
        window.location.href = 'listar_pedidos.php';
    } else {
        alert('Erro: ' + (resultado.erro || 'Erro ao atualizar pedido.'));
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
