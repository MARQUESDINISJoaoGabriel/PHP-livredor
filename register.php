<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $errors = [];

    if (empty($username) || empty($password)) {
        $errors[] = 'Tous les champs sont obligatoires.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
        $stmt->execute(['username' => $username, 'password' => $hashedPassword]);

        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form method="post">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">S'inscrire</button>
    </form>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
