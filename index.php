<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: livredor.php');
    exit;
} else {
    header('Location: login.php');
    exit;
}
