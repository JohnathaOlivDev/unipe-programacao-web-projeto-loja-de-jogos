<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/../db_connect.php';

$user = null;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<nav class="navbar">
    <h3 class="logo">Loja de Jogos</h3>

    <div class="nav-right">
        <?php if ($user): ?>
            <span class="welcome">Olá, <?= htmlspecialchars($user['username']) ?>!</span>
            <a href="wishlist.php" class="btn btn-warning btn-sm">Lista de Desejos</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Sair</a
        <?php else: ?>
            <a href="login.php" class="btn btn-primary btn-sm">Entrar</a>
            <a href="register.php" class="btn btn-secondary btn-sm">Criar Conta</a>
        <?php endif; ?>
    </div>
</nav>
