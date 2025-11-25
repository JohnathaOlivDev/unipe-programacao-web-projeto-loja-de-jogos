<?php
require_once 'db_connect.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['password'])) {

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        header("Location: index.php");
        exit;
    }

    $error = "Usuário ou senha inválidos!";
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/forms.css">
</head>
<body>

<form method="POST" class="login-box">
  <h2>Login</h2>

  <?php if ($error): ?>
    <p class="error"><?= $error ?></p>
  <?php endif; ?>

  <input type="text" name="username" placeholder="Usuário" required>
  <input type="password" name="password" placeholder="Senha" required>

  <button>Entrar</button>
  <a href="register.php">Criar conta</a>
</form>

</body>
</html>
