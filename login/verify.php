<?php
require_once 'session_handler.php'; // Include session handler
header('Content-Type: application/json');

// Assuming your users table has an 'id' column
function verifyPassword($email, $password, $pdo) {
    $stmt = $pdo->prepare('SELECT user_id, password FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        return $user['user_id'];
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    $response = ['success' => false];

    if (empty($email) || empty($password)) {
        $response['message'] = 'Email and password are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email format';
    } else {
        try {
            $user_id = verifyPassword($email, $password, $pdo);
            if ($user_id) {
                // Regenerate session ID to prevent fixation
                session_regenerate_id(true);
                
                // Store user info in session
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['logged_in_at'] = time();

                $response['success'] = true;
                $response['message'] = 'Login successful';
                $response['redirect'] = 'd';
            } else {
                $response['message'] = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    }
    
    echo json_encode($response);
    exit;
}
?>