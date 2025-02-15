<?php
// Start session
session_start();

function redirectToLogin()
{
    header("Location: ../");
    exit();
}

// Check if the user_token exists in session or session storage
if (isset($_SESSION['user_token'])) {
    $userToken = $_SESSION['user_token'];
} elseif (isset($_COOKIE['user_token'])) {
    $userToken = $_COOKIE['user_token'];
} else {
    // Neither session nor cookie contains the user token, redirect to login
    $_SESSION['errorMessages'] = ['Token missing or invaild'];
    redirectToLogin();
}

// Retrieve user details using the token
$query = "SELECT admin_id FROM admins WHERE user_token = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    $_SESSION['errorMessages'] = ['Admin not found.'];
    redirectToLogin();
}
$stmt->bind_param("s", $userToken);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!empty($user)) {
    // Set session variables
    $_SESSION['username'] = $user['admin_id'];
    $_SESSION['user_type'] = 'admin';
} else {
    // Invalid token, redirect to login
    $_SESSION['errorMessages'] = ['Invalid token or multiple login detected.'];
    redirectToLogin();
}

// Check if a session exists and the user type is admin
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'admin') {
    $_SESSION['errorMessages'] = ['Session not found'];
    redirectToLogin();
}

$adid = $_SESSION['username'];

$stmt = $conn->prepare("UPDATE admins SET activities = NOW() WHERE admin_id = ? OR username = ?");
$stmt->bind_param("ss", $adid, $adid);
$stmt->execute();

$sql = "SELECT role FROM admins WHERE admin_id = ? OR username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $adid, $adid);
$stmt->execute();
$resultt = $stmt->get_result();
if ($resultt->num_rows == 1) {
    $admin = $resultt->fetch_assoc();
    $role = $admin["role"];
}
?>