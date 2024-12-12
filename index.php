<?php

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: livredor.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}

// Ce fichier sert à l'initialisation du serveur localhost, c'est uniquement pour rediriger l'utilisateur à une des deux pages et éviter la selection externe de fichiers.