<?php
require_once 'session_handler.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ./');
    exit;
}

// Verify session validity
$stmt = $pdo->prepare("SELECT expires_at FROM sessions WHERE id = :id");
$stmt->execute(['id' => session_id()]);
$session_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$session_data || strtotime($session_data['expires_at']) < time()) {
    session_destroy();
    header('Location: ./');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to Your Dashboard</h1>
        <p>You are logged in as: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
        <p>Logged in since: <?php echo date('Y-m-d H:i:s', $_SESSION['logged_in_at']); ?></p>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>