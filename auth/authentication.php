<?php
date_default_timezone_set('Asia/Dhaka');
// Function to encrypt data
function encryptData($data, $key) {
    // Generate a random IV
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES-256-CBC
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    // Prepend IV to encrypted data
    $encryptedDataWithIV = $iv . $encryptedData;
    // Encode to base64 to ensure data integrity
    return base64_encode($encryptedDataWithIV);
}

// Retrieve form data
$userType = $_POST['user_type'];
$username = $_POST['username'];
$password = $_POST['password'];

// Generate and store authentication key with generation time
$authenticationKey = bin2hex(random_bytes(32)); // Generate a random key
$generationTime = date('Y-m-d H:i:s'); // Get current date and time

// Encrypt sensitive data before storing
$encryptedUserType = encryptData($userType, $authenticationKey);
$encryptedUsername = encryptData($username, $authenticationKey);
$encryptedPassword = encryptData($password, $authenticationKey);
$encryptedGenerationTime = encryptData($generationTime, $authenticationKey);

// Store encrypted data in JSON file
$authData = array(
    'authentication_key' => $authenticationKey,
    'generation_time' => $generationTime,
    'user_type' => $encryptedUserType,
    'username' => $encryptedUsername,
    'password' => $encryptedPassword
);
$jsonData = json_encode($authData);
file_put_contents('authentication_key.json', $jsonData);

// Redirect to the login endpoint with authentication data in query parameters
$redirectUrl = 'http://192.168.103/bob_offline/login_authentication.php';
$redirectUrl .= '?authentication_key=' . urlencode($authenticationKey);
$redirectUrl .= '&generation_time=' . urlencode($encryptedGenerationTime);
$redirectUrl .= '&user_type=' . urlencode($encryptedUserType);
$redirectUrl .= '&username=' . urlencode($encryptedUsername);
$redirectUrl .= '&password=' . urlencode($encryptedPassword);

header("Location: $redirectUrl");
exit();
?>
