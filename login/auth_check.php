<?php
session_start();
require_once '../conn.php';

// Function to validate token and refresh session
function validateToken($pdo) {
    if (isset($_COOKIE['remember_me'])) {
        $token = $_COOKIE['remember_me'];
        $stmt = $pdo->prepare('SELECT user_id, expires_at FROM user_sessions WHERE token = :token');
        $stmt->execute(['token' => $token]);
        $session = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($session && strtotime($session['expires_at']) > time()) {
            // Token is valid, restore session
            $stmt = $pdo->prepare('SELECT email FROM users WHERE student_id = :student_id'); // Fixed 'student_id' to 'id'
            $stmt->execute(['student_id' => $session['user_id']]);
            $email = $stmt->fetchColumn();

            if ($email) {
                $_SESSION['user_id'] = $session['user_id'];
                $_SESSION['user_email'] = $email;
                // Regenerate session ID for security on token validation
                session_regenerate_id(true);
                return true;
            }
        }
        // If token is invalid or expired, clear the cookie
        setcookie('remember_me', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
    return false;
}

// Check session and token validity on every request
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    // If session is not set, try to validate token
    if (!validateToken($pdo)) {
        // No valid session or token, redirect to login
        header('Location: ./');
        exit;
    }
} else {
    // Verify session data against database to ensure it's still valid
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE student_id = :student_id AND email = :email');
    $stmt->execute([
        'student_id' => $_SESSION['user_id'],
        'email' => $_SESSION['user_email']
    ]);
    
    if ($stmt->fetchColumn() == 0) {
        // Session data is invalid (e.g., user deleted), clear everything
        session_destroy();
        if (isset($_COOKIE['remember_me'])) {
            $stmt = $pdo->prepare('DELETE FROM user_sessions WHERE token = :token');
            $stmt->execute(['token' => $_COOKIE['remember_me']]);
            setcookie('remember_me', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        }
        header('Location: ./');
        exit;
    }
    
    // Session is valid, regenerate ID periodically for security
    if (!isset($_SESSION['last_regenerate']) || (time() - $_SESSION['last_regenerate']) > 1800) { // Every 30 minutes
        session_regenerate_id(true);
        $_SESSION['last_regenerate'] = time();
    }
}

// If we reach here, the user is authenticated via session or token
?>