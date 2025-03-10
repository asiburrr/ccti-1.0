<?php
include '../session.php';
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    echo "Logged in as: " . htmlspecialchars($_SESSION['user_id']);
    echo "<br>CSRF Token: " . $_SESSION['csrf_token'];
} else {
    echo "Not authenticated.";
}
?>