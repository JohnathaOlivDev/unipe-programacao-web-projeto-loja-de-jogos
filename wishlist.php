<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("<p>Faça login para ver sua lista de desejos. <a href='login.php'>Entrar</a></p>");
}

$user = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT games.*
    FROM wishlist
    JOIN games ON games.id = wishlist.game_id
    WHERE wishlist.user_id = ?
");
$stmt->execute([$user]);
$games = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/cards.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container py-4">
    <h2 class="mb-4">❤️ Minha Lista de Desejos</h2>

    <div class="row g-4">
        <?php foreach ($games as $game): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">

                    <img src="<?= $game['head_image'] ?>" class="card-img-top">

                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($game['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($game['genre']) ?></p>
                        <a href="game.php?id=<?= $game['id'] ?>" class="btn btn-outline-light btn-sm">Ver mais</a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

</body>
</html>
