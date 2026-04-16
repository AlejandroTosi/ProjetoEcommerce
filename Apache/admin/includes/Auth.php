<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
     header("Location: /admin/login/login.php");
   }
if (session_status() === PHP_SESSION_ACTIVE){
    $token = $_SESSION['user']['token'] ?? null;
}
?>