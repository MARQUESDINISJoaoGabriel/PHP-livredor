<?php
// settings pour la PDO
$host = '127.0.0.1:3306';
$dbname = 'livredor'; 
$user = 'root';
$password = ''; 

// gestion de la database!
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
