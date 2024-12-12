<?php
session_start();
require 'inclus/db.php';

if (!isset($_SESSION['user_id'])) { // si la session n'as pas d'user_id (donc s'il n'y a pas de login.)
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']); // Là on évite les espaces inutiles au début " style ça", et à la fin "en mode ça "
    $user_id = $_SESSION['user_id'];

    if (!empty($message)) { // Insertion du message écrit!
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

$stmt = $pdo->query('SELECT m.id, m.content, m.created_at, m.user_id, u.username, u.color
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
    <link rel="icon" type="image/x-icon" href="assets/117.ico">
    <title>Livre d'Or</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <img src="assets/LivredOr.png" alt="Logo Livre d'Or" style="width: 30%; height:30%"> 
        <img src="assets/LivreDorDesc.png" alt="Le Livre d'Or est un receuil qui contient les impressions et commentaires d'utilisateurs. Ici, vous pouvez envoyer vos petits messages ou longues histoires afin d'en garder un souvenir sympathique! Comme un historique de logs..." style="width: 30%; height:30%; margin-left:100px;"> 
        <img src="assets/php-icon.png" alt="icone php" class="phpicon">
        <h3>Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?>.</h3> 
        <nav>
            <a class="deconnect" href="logout.php">Déconnexion</a>
        </nav>
    </header>
    <main>
        <!-- ZONE ECRITURE-->
        <section> 
            <img src="assets/EcrivezMot.png" alt="Ecrivez un petit mot..." style="width: 30%; height:10%">
            <form action="livredor.php" method="POST">
                <textarea name="message" placeholder="Ecrivez ici, et envoyez!" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </section>
          <br>
        <hr>
        <hr>
        
        <!-- ZONE HISTORIQUE DES MESSAGES-->
        <section>
            <h3 class="messages">Historique des messages ー depuis le 12/12/2024</h3>
            <?php if (count($messages) > 0): // Si il y a bien plus de 0 messages (donc s'il y en a...)?>
                <ul>
                    <?php foreach ($messages as $message): ?>
                        <li style="border-top: 5px solid <?= htmlspecialchars($message['color']); ?>;">
                            <p>
                                <strong style="color: <?= htmlspecialchars($message['color']); ?>;">
                                    <?= htmlspecialchars($message['username']); ?>:
                                </strong> 
                                <?= nl2br(htmlspecialchars($message['content'])); ?>
                            </p>
                            <p class="date"><?= htmlspecialchars($message['created_at']); ?></p>
                            <?php if ($_SESSION['user_id'] == $message['user_id']): // Ici, le cas où des messages envoyés par le compte actuel connecté sont présents?> 
                                <form action="livredor.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_message_id" value="<?= $message['id']; ?>">
                                    <button type="submit" name="delete_message" class="delete-button">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

            <?php else: // si le nombre de messages n'est pas supérieur à zero... ?> 
                <p>Aucun message pour le moment.</p>
            <?php endif; ?>
        </section>

    </main>
</body>
</html>
