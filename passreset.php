<?php
require_once 'inclus/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        echo "ERREUR / Les mots de passes sont différents.";
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE id = ?");
        $stmt->execute([$hashedPassword, $user['id']]);

        echo "<p>Votre mot de passe a été réinitialisé avec succès. --> <a href='login.php'>Connectez-vous.</a></p>";
    } else {
        echo "Le lien de réinitialisation (TOKEN) est invalide ou expiré.";
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    echo "Aucun token fourni.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Réinitialiser le mot de passe</h1>
    <form method="POST" action="">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
        <label for="password">Nouveau mot de passe :</label>
        <input type="password" name="password" id="password" required>
        <label for="confirm_password">Confirmez le mot de passe :</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <button type="submit">Réinitialiser</button>
    </form>
</body>
</html>
