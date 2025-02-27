<?php
require_once 'session_handler.php';

// Delete session from database
$stmt = $pdo->prepare("DELETE FROM sessions WHERE id = :id");
$stmt->execute(['id' => session_id()]);

session_destroy();
header('Location: login.php');
exit;
?>