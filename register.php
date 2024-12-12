<?php
require 'inclus/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $color = trim($_POST['color']);
    $errors = [];

    // Tests Unitaires, on fait un tableau pour insérez les bugs et donc ne pas valider l'étape "empty(errors)", donc tant qu'erreurs n'est pas vide, pas d'passage.
    if (empty($username) || empty($password)) {
        $errors[] = 'Tous les champs sont obligatoires.';
    }

    if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
        $errors[] = 'Couleur invalide.';
    }

    if (strlen($password) < 6) {
        $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
    }
    
    // Si pas d'erreurs...
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errors[] = 'Ce nom d\'utilisateur est déjà pris. Changez de pseudonyme ou connectez vous.'; 
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // On "hash" le mot de passe, simple fonction

            $stmt = $pdo->prepare('INSERT INTO users (username, password, color) VALUES (:username, :password, :color)');:
            $stmt->execute([
                'username' => $username,
                'password' => $hashedPassword,
                'color' => $color 
            ]); // Et enfin on insère les données.


            header('Location: login.php'); // Redirection au Login.
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription ー Au livre d'Or...</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Inscription ー Au livre d'Or...</h1>
    <form method="post">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required><br>
        <label>Mot de passe :</label>
        <input type="password" name="password" required><br>
        <label>Couleur préférée (pour vos messages) :</label>
        <input type="color" name="color" value="#000000" required><br>
        
        <button type="submit">S'inscrire</button>
    </form>
    <br>
    <p>Déjà inscrit? <a href="login.php">Cliquez ici</a></p>
    
    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li> <!-- On display l'erreur en bas de la page (s'il y en a.)-->
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>
