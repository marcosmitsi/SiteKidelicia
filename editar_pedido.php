<?php
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
?>

<h2 class="mb-4">Editar Pedido #<?= $pedido['id'] ?></h2>

<form id="formPedido" class="bg-white p-4 rounded shadow-sm">
    <input type="hidden" name="id" value="<?= $pedido['id'] ?>">

    <div class="mb-3">
        <label class="form-label">Cliente</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($pedido['nome_cliente']) ?>" readonly>
    </div>

    <h5 class="mt-4">Itens do Pedido</h5>

    <table id="tabelaItens" class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th style="width: 100px;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedido['itens'] as $item): ?>
                <tr>
                    <td>
                        <select name="produto_id[]" class="form-select" required>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?= $produto['id'] ?>" <?= $produto['id'] == $item['produto_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($produto['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" class="form-control" name="quantidade[]" value="<?= $item['quantidade'] ?>" min="1" required></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger removerItem">Remover</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button type="button" class="btn btn-secondary mb-3" id="adicionarItem">+ Adicionar Produto</button><br>
    <button type="submit" class="btn btn-success">Salvar Alterações</button>
</form>

<a href="listar_pedidos.php" class="btn btn-link mt-3">← Voltar para a listagem</a>

<script>
    const produtos = <?= json_encode($produtos) ?>;

    document.getElementById('adicionarItem').addEventListener('click', function () {
        const novaLinha = document.createElement('tr');
        novaLinha.innerHTML = `
            <td>
                <select name="produto_id[]" class="form-select" required>
                    ${produtos.map(p => `<option value="${p.id}">${p.nome}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" class="form-control" name="quantidade[]" value="1" min="1" required></td>
            <td>
                <button type="button" class="btn btn-sm btn-danger removerItem">Remover</button>
            </td>
        `;
        document.querySelector('#tabelaItens tbody').appendChild(novaLinha);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('removerItem')) {
            e.target.closest('tr').remove();
        }
    });

    document.getElementById('formPedido').addEventListener('submit', async function (e) {
        e.preventDefault();

        const pedidoId = <?= $pedido['id'] ?>;
        const produtoIds = Array.from(document.querySelectorAll('select[name="produto_id[]"]')).map(el => el.value);
        const quantidades = Array.from(document.querySelectorAll('input[name="quantidade[]"]')).map(el => el.value);

        const itens = produtoIds.map((id, i) => ({
            produto_id: parseInt(id),
            quantidade: parseInt(quantidades[i])
        }));

        const data = {
            cliente_id: <?= $pedido['cliente_id'] ?>,
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
