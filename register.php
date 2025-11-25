<?php
require_once 'db_connect.php';
require_once __DIR__ . '/includes/session.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // checar se nome já existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$user]);

    if ($stmt->rowCount() > 0) {
        $error = "Este nome já está em uso.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$user, $pass]);

        $success = "Conta criada com sucesso! Faça login.";
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
  <h2>Criar conta</h2>

  <?php if ($error): ?>
    <p class="error"><?= $error ?></p>
  <?php endif; ?>

  <?php if ($success): ?>
    <p class="success"><?= $success ?></p>
  <?php endif; ?>

  <input type="text" name="username" placeholder="Usuário" required>
  <input type="password" name="password" placeholder="Senha" required>

  <button>Criar conta</button>
  <a href="login.php">Já tenho conta</a>
</form>

</body>
</html>
