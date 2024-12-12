<?php
require_once './db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user) {
        $token = bin2hex(random_bytes(32)); // On va génerer un token unique qui va servir (temporairement) comme clé pour 
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expiry = ? WHERE username = ?");
        $stmt->execute([$token, $expiry, $username]);

        $resetLink = "http://localhost/livredor/passreset.php?token=$token";
        echo "<p>Lien de réinitialisation généré : <a href='$resetLink'>$resetLink</a></p>"; // Apparition du lien 
    } else {
        echo "<p>Cet utilisateur n'existe pas, dirigez-vous vers la --> <a href='../register.php'>page d'inscription</a>.</p>"; // si l'user n'existe pas...
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Mot de passe oublié</h1>
    <form method="POST" action="">
        <label for="username">Votre pseudo :</label>
        <input type="text" name="username" id="username" required>
        <button type="submit">Générer un lien de réinitialisation</button>
    </form>
</body>
</html>
