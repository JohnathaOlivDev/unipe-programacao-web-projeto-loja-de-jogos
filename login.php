<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/db_connect.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $errors[] = "Usuário ou senha incorretos.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/forms.css">
</head>
<body>
<form method="POST" class="login-box">
    <h2>Login</h2>
    <?php foreach ($errors as $error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>
    <input type="text" name="username" placeholder="Usuário" required>
    <input type="password" name="password" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>
