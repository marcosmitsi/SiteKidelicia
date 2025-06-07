<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config/database.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($email && $senha) {
        try {
            $pdo = getConnection();
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                if ($usuario['status'] !== 'ativo') {
                    $erro = "Usuário inativo. Entre em contato com o administrador.";
                } else {
                    $_SESSION['usuario'] = [
                        'id' => $usuario['id'],
                        'nome' => $usuario['nome'],
                        'email' => $usuario['email'],
                        'nivel_acesso' => $usuario['nivel_acesso']
                    ];
                    header("Location: index.php");
                    exit;
                }
            } else {
                $erro = "E-mail ou senha inválidos.";
            }
        } catch (Exception $e) {
            $erro = "Erro ao acessar o sistema: " . $e->getMessage();
        }
    } else {
        $erro = "Preencha todos os campos.";
    }
}

// Redireciona se já estiver logado
if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<?php require_once 'includes/header.php'; ?>

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow p-4">
        <h4 class="text-center mb-4">Acesso ao Sistema</h4>

        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($email ?? '') ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" name="senha" id="senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
