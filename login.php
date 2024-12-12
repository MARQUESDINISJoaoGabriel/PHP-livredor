<?php
require 'inclus/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; // Des simples comparaisons en récupérant les élements depuis la DB
        header('Location: livredor.php');
        exit;
    } else {
        $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion ー Au Livre D'Or...</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Login ー Au livre d'Or...</h1>
    <img src="assets/php-icon.png" alt="icone php" class="phpicon">
    <form method="post">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required><br>
        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>
        <button type="submit">Se connecter</button>
    </form>
    <br>
    <a href="inclus/requete_passreset.php">Mot de passe oublié ?</a>
    <p>Pas inscris? <a href="register.php">Cliquez ici</a></p>
    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error) ?></p> <!-- On display l'erreur en bas de la page.-->
    <?php endif; ?>
</body>
</html>
