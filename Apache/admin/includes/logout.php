<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // Log out the user by destroying the session
    session_destroy();
    // Redirect to the login page or homepage
    header('Location: /path-to-login-or-homepage');
    exit();
} else {
    // If no user is logged in, redirect to login page
    header('Location: /path-to-login');
    exit();
}
?>