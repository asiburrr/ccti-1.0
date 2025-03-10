<?php
include 'session.php'; 
setcookie("user_token", "", time() - 3600, "/");
setcookie("user_type", "", time() - 3600, "/");
session_unset();
session_destroy();
header("Location: " . BASE_PATH . "/auth/login");
exit;
?>