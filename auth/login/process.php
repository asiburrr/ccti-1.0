<?php
// ccti/auth/login/process.php

include '../../connection.php'; 
session_start();

function generateRndm($length = 64) {
    return bin2hex(random_bytes($length));
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['csrfToken']) || $data['csrfToken'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

if (!isset($data['userID']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Missing user ID or password']);
    exit;
}

$userID = $data['userID'];
$password = $data['password'];

// Query to fetch user data including first_name and last_name
$query = "SELECT user_id, password, first_name, last_name, photos, token FROM users WHERE user_id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $storedPasswordHash = $user['password'];

        if (password_verify($password, $storedPasswordHash)) {
            $userToken = generateRndm(64);

            // Generate text-based photo if not set
            $photo = $user['photos'];
            if (empty($photo)) {
                $firstInitial = strtoupper(substr($user['first_name'], 0, 1));
                $lastInitial = !empty($user['last_name']) ? strtoupper(substr($user['last_name'], 0, 1)) : '';
                $initials = $firstInitial . $lastInitial;
                $photo = "https://placehold.co/150/00008B/FFFFFF?text=" . urlencode($initials);
            }

            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['photo'] = $photo;
            $_SESSION['user_token'] = $userToken;
            $_SESSION['user_type'] = "user";
            $_SESSION['authenticated'] = true;

            setcookie("user_token", $userToken, time() + (200 * 24 * 3600), "/", "", false, true);
            setcookie("user_type", "user", time() + (200 * 24 * 3600), "/", "", false, true);

            $updateQuery = "UPDATE users SET token = ? WHERE user_id = ?";
            if ($updateStmt = $conn->prepare($updateQuery)) {
                $updateStmt->bind_param("ss", $userToken, $userID);
                $updateStmt->execute();
                $_SESSION['successMessages'] = ["Login Successful."];
                echo json_encode(['success' => true, 'message' => 'Login successful']);
                $updateStmt->close();
            } else {
                error_log('Failed to prepare update statement: ' . $conn->error);
                echo json_encode(['success' => false, 'message' => 'Error updating token']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
    $stmt->close();
} else {
    error_log('Failed to prepare select statement: ' . $conn->error);
    echo json_encode(['success' => false, 'message' => 'Error preparing query']);
}

$conn->close();
?>