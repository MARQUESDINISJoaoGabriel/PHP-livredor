<?php
require 'includes/db.php';
require 'functions/auth.php';
require 'functions/livredor.php';
session_start();

redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    if (!empty($content)) {
        addMessage($pdo, $_SESSION['user_id'], $content);
    }
}

$messages = getMessages($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<?php include 'includes/header.php'; ?>
<body>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?> !</h1>
    <a href="logout.php">Déconnexion</a>
    <form method="post">
        <textarea name="content" required></textarea>
        <button type="submit">Soumettre</button>
    </form>

    <h2>Messages</h2>
    <?php foreach ($messages as $message): ?>
        <p><strong><?= htmlspecialchars($message['username']) ?></strong> (<?= $message['created_at'] ?>) :</p>
        <p><?= htmlspecialchars($message['content']) ?></p>
    <?php endforeach; ?>
</body>
<?php include 'includes/footer.php'; ?>
</html>
