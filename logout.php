<?php
session_start();
session_unset(); 
session_destroy(); // Simple redirection et "exit" du compte.
header('Location: login.php');
exit();
?>
