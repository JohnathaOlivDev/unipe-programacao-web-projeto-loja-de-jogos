<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userName = $_SESSION['username'] ?? null;
?>

<nav class="navbar navbar-dark px-4">
    <h3 class="text-light">Loja de Jogos</h3>

    <div class="d-flex align-items-center gap-3">

        <?php if ($userName): ?>
            <span class="text-light">Olá, <strong><?= htmlspecialchars($userName) ?></strong></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Sair</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-outline-light btn-sm">Login</a>
        <?php endif; ?>

    </div>
</nav>
