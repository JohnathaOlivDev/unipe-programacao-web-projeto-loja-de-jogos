<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado.");
}

if (!isset($_POST['game_id'])) {
    die("Jogo inválido.");
}

$user = $_SESSION['user_id'];
$game = intval($_POST['game_id']);

$stmt = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = ? AND game_id = ?");
$stmt->execute([$user, $game]);

if ($stmt->fetch()) {
    header("Location: wishlist.php?msg=already");
    exit;
}

$stmt = $pdo->prepare("INSERT INTO wishlist (user_id, game_id) VALUES (?, ?)");
$stmt->execute([$user, $game]);

header("Location: wishlist.php?msg=added");
exit;
