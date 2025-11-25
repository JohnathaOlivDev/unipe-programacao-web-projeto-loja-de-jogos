<?php
require_once __DIR__ . '/../db_connect.php';

$csvFile = __DIR__ . '/steamgames.csv';

if (!file_exists($csvFile)) die("CSV não encontrado");

$handle = fopen($csvFile, 'r');
$header = fgetcsv($handle);

$stmt = $pdo->prepare("
    INSERT INTO games (app_id, title, release_date, price, metacritic_score, user_score,
                       developer, publisher, genre, head_image, screenshots, movies)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$count = 0;
while (($row = fgetcsv($handle)) !== false) {
    try {
        $stmt->execute($row);
        $count++;
    } catch (Exception $e) {
        continue;
    }
}
fclose($handle);

echo "✅ Importação concluída: $count jogos";
