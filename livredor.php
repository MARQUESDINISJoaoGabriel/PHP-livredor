<?php
session_start();
require 'inclus/db.php';

if (!isset($_SESSION['user_id'])) { // si la session n'as pas d'user_id (donc s'il n'y a pas de login.)
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    $user_id = $_SESSION['user_id'];

    if (!empty($message)) {
        $stmt = $pdo->prepare('INSERT INTO messages (user_id, content) VALUES (:user_id, :content)');
        $stmt->execute([
            ':user_id' => $user_id,
            ':content' => $message
        ]);

        header('Location: livredor.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message'])) {
    $message_id = $_POST['delete_message_id'];
    $user_id = $_SESSION['user_id'];

    // Vérifiez si l'utilisateur est l'auteur du message
    $stmt = $pdo->prepare('SELECT user_id FROM messages WHERE id = :message_id');
    $stmt->execute([':message_id' => $message_id]);
    $message_user_id = $stmt->fetchColumn();

    if ($message_user_id == $user_id) {
        $stmt = $pdo->prepare('DELETE FROM messages WHERE id = :message_id');
        $stmt->execute([':message_id' => $message_id]);
    }

    header('Location: livredor.php');
    exit();
}

$stmt = $pdo->query('SELECT m.id, m.content, m.created_at, m.user_id, u.username
                     FROM messages m
                     JOIN users u ON m.user_id = u.id
                     ORDER BY m.created_at DESC');
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h3>Bienvenue dans le Livre d'or...</h3>
        <h1><?= htmlspecialchars($_SESSION['username']) ?></h1>
        <nav>
            <a class="deconnect" href="login.php">Déconnexion</a>
            <p> </p>
        </nav>
    </header>
    <main>
        <section>
            <h2>Envoyer un petit mot...</h2>
            <form action="livredor.php" method="POST">
                <textarea name="message" placeholder="Ecrivez ici, et envoyez!" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </section>
          <br>
        <hr>
        <hr>
        
        <section>
            <h3 class="messages">Messages</h3>
            <?php if (count($messages) > 0): ?>
                <ul>
                    <?php foreach ($messages as $message): ?>
                        <li>
                            <p><strong><?= htmlspecialchars($message['username']); ?>:</strong> <?= nl2br(htmlspecialchars($message['content'])); ?></p>
                            <p class="date"><?= htmlspecialchars($message['created_at']); ?></p>
                            <?php if ($_SESSION['user_id'] == $message['user_id']): ?>
                                <form action="livredor.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_message_id" value="<?= $message['id']; ?>">
                                    <button type="submit" name="delete_message" class="delete-button">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun message pour le moment.</p>
            <?php endif; ?>
        </section>

    </main>
</body>
</html>
