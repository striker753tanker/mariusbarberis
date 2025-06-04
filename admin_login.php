<?php
session_start();
$correctPassword = 'marius2025'; // 🔐 Change this to your secure password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password === $correctPassword) {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = "Neteisingas slaptažodis.";
    }
}
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Admin Prisijungimas</title>
    <style>
        body { font-family: sans-serif; background-color: #111; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: #222; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.5); }
        input { width: 100%; padding: 10px; margin-top: 10px; }
        button { margin-top: 15px; padding: 10px; background: #28a745; color: white; border: none; width: 100%; }
        p { color: red; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Prisijungimas</h2>
        <?php if (!empty($error)) echo "<p>$error</p>"; ?>
        <form method="POST">
            <input type="password" name="password" placeholder="Slaptažodis" required>
            <button type="submit">Prisijungti</button>
        </form>
    </div>
</body>
</html>