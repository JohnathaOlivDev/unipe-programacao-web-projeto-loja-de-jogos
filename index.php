<?php
require_once __DIR__ . '/db_connect.php';
$stmt = $pdo->query("SELECT * FROM games ORDER BY id ASC");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Loja de Jogos</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/cards.css">
</head>
<body>

<div class="container py-4">
  <div class="row g-4">
    <?php foreach ($games as $game): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100">
          
          <?php if (!empty($game['head_image'])): ?>
              <img src="<?= $game['head_image'] ?>" class="card-img-top">
          <?php else: ?>
              <img src="assets/img/placeholder.jpg" class="card-img-top">
          <?php endif; ?>

          <div class="card-body">
            <h5 class="card-title"><?= $game['title'] ?></h5>
            <p class="card-text"><?= $game['genre'] ?></p>
            <p class="price">R$ <?= number_format($game['price'], 2, ',', '.') ?></p>
            <a href="game.php?id=<?= $game['id'] ?>" class="btn btn-outline-light btn-sm">Ver mais</a>
          </div>

        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>
