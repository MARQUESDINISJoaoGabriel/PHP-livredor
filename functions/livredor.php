<?php
function getMessages(PDO $pdo) {
    $stmt = $pdo->query('SELECT messages.content, messages.created_at, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.created_at DESC');
    return $stmt->fetchAll();
}

function addMessage(PDO $pdo, $userId, $content) {
    $stmt = $pdo->prepare('INSERT INTO messages (user_id, content) VALUES (:user_id, :content)');
    $stmt->execute(['user_id' => $userId, 'content' => $content]);
}

function deleteMessage(PDO $pdo, $messageId, $userId) {
    $stmt = $pdo->prepare('DELETE FROM messages WHERE id = :id AND user_id = :user_id');
    $stmt->execute(['id' => $messageId, 'user_id' => $userId]);
}
