<?php
require_once __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../connection.php';
include __DIR__ . '/../config.php';

session_start();

function generateCsrfToken() {
    return bin2hex(random_bytes(32));
}

// Function to require login, callable when needed
function requireLogin($loginPath = '/auth/login') {
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: " . BASE_PATH . $loginPath);
        $_SESSION['errorMessages'] = ["Please Login"];
        exit;
    }
}

if (isset($_COOKIE['user_token']) && isset($_COOKIE['user_type'])) {
    $userToken = $_COOKIE['user_token'];
    $userType = $_COOKIE['user_type'];

    // Validate user_token against the database, fetch first_name, last_name, and photo
    $query = "SELECT user_id, first_name, last_name, photos, token FROM users WHERE token = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $userToken);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $storedToken = $user['token'];
            $userId = $user['user_id'];

            if ($userToken === $storedToken) {
                // Generate text-based s if not set
                $photo = $user['photos'];
                if (empty($photo)) {
                    $firstInitial = strtoupper(substr($user['first_name'], 0, 1));
                    $lastInitial = !empty($user['last_name']) ? strtoupper(substr($user['last_name'], 0, 1)) : '';
                    $initials = $firstInitial . $lastInitial;
                    $photo = "https://placehold.co/40/00008B/FFFFFF?text=" . urlencode($initials);
                }

                // Set session variables
                $_SESSION['user_id'] = $userId;
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['photo'] = $photo;
                $_SESSION['user_token'] = $userToken;
                $_SESSION['user_type'] = $userType;
                $_SESSION['authenticated'] = true;

                session_regenerate_id(true);

                if (!isset($_SESSION['csrf_token'])) {
                    $_SESSION['csrf_token'] = generateCsrfToken();
                }
            } else {
                setcookie("user_token", "", time() - 3600, "/");
                setcookie("user_type", "", time() - 3600, "/");
                session_unset();
                session_destroy();
                error_log("Token mismatch: Cookie token = $userToken, DB token = $storedToken");
            }
        } else {
            setcookie("user_token", "", time() - 3600, "/");
            setcookie("user_type", "", time() - 3600, "/");
            session_unset();
            session_destroy();
            error_log("No user found for token: $userToken");
        }
        $stmt->close();
    } else {
        error_log('Failed to prepare session validation query: ' . $conn->error);
    }
} else {
    if (isset($_SESSION['authenticated'])) {
        session_unset();
        session_destroy();
    }
    error_log("Cookies not set: user_token or user_type missing");
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCsrfToken();
}
?>