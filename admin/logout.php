<?php
session_start();

// Unset session variable
unset($_SESSION['user_token']);

// Destroy the session
session_destroy();

// Unset and expire the cookie
if (isset($_COOKIE['user_token'])) {
    unset($_COOKIE['user_token']);
    setcookie('user_token', '', time() - 3600, '/');
}

// Redirect to login page
header("Location: ../admin_login");
exit();
?>
