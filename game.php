<?php
require_once __DIR__ . '/db_connect.php';



if (!isset($_GET['id'])) {
    die("Jogo não encontrado.");
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM games WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$game) {
    die("Jogo não encontrado.");
}

$screenshots = array_filter(array_map('trim', explode(',', $game['screenshots'])));
$movies = array_filter(array_map('trim', explode(',', $game['movies'])));

$media = [];
foreach ($movies as $mv) $media[] = ['type' => 'video', 'src' => $mv];
foreach ($screenshots as $img) $media[] = ['type' => 'image', 'src' => $img];
?>

<?php include __DIR__ . "/includes/header.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($game['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/game.css">
</head>
<body>

<div class="container py-4">

    <h2 class="game-title mb-4"><?= htmlspecialchars($game['title']) ?></h2>

    <div id="carouselMedia" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">

            <?php foreach ($media as $i => $item): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">

                    <?php if ($item['type'] === 'video'): ?>
                        <video class="d-block w-100 carousel-video" muted playsinline controls>
                            <source src="<?= $item['src'] ?>" type="video/mp4">
                        </video>
                    <?php else: ?>
                        <img src="<?= $item['src'] ?>" class="d-block w-100 carousel-image">
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>

        <button class="carousel-control-prev custom-control" type="button" data-bs-target="#carouselMedia" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next custom-control" type="button" data-bs-target="#carouselMedia" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <div class="game-info">
        <p><strong>Gênero:</strong> <?= htmlspecialchars($game['genre']) ?></p>
        <p><strong>Desenvolvedora:</strong> <?= htmlspecialchars($game['developer']) ?></p>
        <p><strong>Editora:</strong> <?= htmlspecialchars($game['publisher']) ?></p>
        <p><strong>Preço:</strong> R$ <?= number_format($game['price'], 2, ',', '.') ?></p>
        <p><strong>Data de lançamento:</strong> <?= htmlspecialchars($game['release_date']) ?></p>
        <p><strong>Avaliação (Metacritic):</strong> <?= htmlspecialchars($game['metacritic_score']) ?></p>
        <p><strong>Avaliação dos usuários:</strong> <?= htmlspecialchars($game['user_score']) ?></p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST" action="wishlist_add.php">
                <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                <button class="btn btn-outline-warning mt-3">Adicionar à lista de desejos</button>
            </form>
<?php else: ?>
    <p class="text-warning mt-3">
        <a href="login.php">Faça login</a> para adicionar à lista de desejos.
    </p>
<?php endif; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
const carousel = document.querySelector('#carouselMedia');
const videos = document.querySelectorAll('#carouselMedia video');

carousel.addEventListener('slid.bs.carousel', function () {
    const activeSlide = carousel.querySelector('.carousel-item.active');
    const video = activeSlide.querySelector('video');

    videos.forEach(v => {
        v.pause();
        v.currentTime = 0;
    });

    if (video) video.play();
});

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        const video = entry.target;
        if (entry.isIntersecting) {
            video.play();
        } else {
            video.pause();
            video.currentTime = 0;
        }
    });
}, { threshold: 0.5 });

videos.forEach(video => observer.observe(video));
</script>

</body>
</html>
