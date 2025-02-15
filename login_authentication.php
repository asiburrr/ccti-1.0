<?php
function generaterndm($length = 32)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $rndm = '';

    // Ensure the first character is a letter
    $rndm .= $characters[rand(10, 51)]; // 10 is the index of 'a', and 51 is the index of 'Z'

    for ($i = 1; $i < $length; $i++) {
        $rndm .= $characters[rand(0, $charactersLength - 1)];
    }

    return $rndm;
}

// Generate a 32-character random encryption key
$enKey = generaterndm(32);

include 'encryption.php';
include 'connection.php';


// Function to decrypt data
function decryptData($encryptedData, $key)
{
    // Decode from base64
    $encryptedDataWithIV = base64_decode($encryptedData);
    // Extract IV
    $ivSize = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($encryptedDataWithIV, 0, $ivSize);
    $encryptedDataWithoutIV = substr($encryptedDataWithIV, $ivSize);
    // Decrypt data using AES-256-CBC
    return openssl_decrypt($encryptedDataWithoutIV, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

// Retrieve encrypted form data
$authenticationKey = htmlspecialchars($_GET['authentication_key'] ?? '');
$encryptedGenerationTime = htmlspecialchars($_GET['generation_time'] ?? '');
$encryptedUserType = htmlspecialchars($_GET['user_type'] ?? '');
$encryptedUsername = htmlspecialchars($_GET['username'] ?? '');
$encryptedPassword = htmlspecialchars($_GET['password'] ?? '');

// Validate authentication key and generation time
if (empty($authenticationKey) || empty($encryptedGenerationTime)) {
    $_SESSION['errorMessages'] = ["Authentication failed: Missing Keys"];
    header("Location: http://192.168.0.103/bob_offline/admin_login?$enKey&err_ey=$encryptionKey&error=auth-failed-missing-keys");
    exit();
}

// Retrieve authentication key and generation time from JSON file
$authJson = file_get_contents('auth/authentication_key.json');
$authData = json_decode($authJson, true);
$authKey = $authData['authentication_key'];

// Validate authentication key
if (empty($authenticationKey) || $authenticationKey !== $authKey) {
    $_SESSION['errorMessages'] = ["Authentication failed: Invalid Data"];
    header("Location: http://192.168.0.103/bob_offline/admin_login?$enKey&err_ey=$encryptionKey&error=auth-failed-invalid-authentication");
    exit();
}

// Decrypt sensitive data
$generationTime = decryptData($encryptedGenerationTime, $authKey);
$userType = decryptData($encryptedUserType, $authKey);
$username = decryptData($encryptedUsername, $authKey);
$password = decryptData($encryptedPassword, $authKey);

// Validate user type, username, and password
if (empty($userType) || empty($username) || empty($password)) {
    $_SESSION['errorMessages'] = ["Authentication failed: Missing Data"];
    header("Location: http://192.168.0.103/bob_offline/admin_login?$enKey&err_ey=$encryptionKey&error=auth-failed-missing-data");
    exit();
}

// Prepare statements to prevent SQL injection
if ($userType === 'admin') {
    // Encrypt the table name and column names for admins
    $tableName = base64_encode(openssl_encrypt("admins", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $usernameColumn = base64_encode(openssl_encrypt("username", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $passwordColumn = base64_encode(openssl_encrypt("password", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $idColumn = base64_encode(openssl_encrypt("admin_id", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));

    $stmt = $conn->prepare("SELECT * FROM " . openssl_decrypt(base64_decode($tableName), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " WHERE (" . openssl_decrypt(base64_decode($usernameColumn), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " = ? OR " . openssl_decrypt(base64_decode($idColumn), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " = ?)");
    $stmt->bind_param("ss", $username, $username);
} else if ($userType === 'teacher') {
    // Encrypt the table name and column names for teachers
    $tableName = base64_encode(openssl_encrypt("teachers", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $usernameColumn = base64_encode(openssl_encrypt("username", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $passwordColumn = base64_encode(openssl_encrypt("password", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $idColumn = base64_encode(openssl_encrypt("teacher_id", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));

    $stmt = $conn->prepare("SELECT * FROM " . openssl_decrypt(base64_decode($tableName), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " WHERE (" . openssl_decrypt(base64_decode($usernameColumn), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " = ? OR " . openssl_decrypt(base64_decode($idColumn), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " = ?)");
    $stmt->bind_param("ss", $username, $username);
} else {
    // Encrypt the table name and column names for users
    $tableName = base64_encode(openssl_encrypt("users", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $usernameColumn = base64_encode(openssl_encrypt("username", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $passwordColumn = base64_encode(openssl_encrypt("password", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));
    $idColumn = base64_encode(openssl_encrypt("student_id", "AES-256-CBC", $encryptionKey, 0, $encryptionKey));

    $stmt = $conn->prepare("SELECT * FROM " . openssl_decrypt(base64_decode($tableName), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " WHERE (" . openssl_decrypt(base64_decode($usernameColumn), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " = ? OR " . openssl_decrypt(base64_decode($idColumn), "AES-256-CBC", $encryptionKey, 0, $encryptionKey) . " = ?)");
    $stmt->bind_param("ss", $username, $username);
}

$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows === 1) {
    // User exists, verify password
    $row = $result->fetch_assoc();
    $hashedPassword = $row[openssl_decrypt(base64_decode($passwordColumn), "AES-256-CBC", $encryptionKey, 0, $encryptionKey)];
    $salt = $row['salt'];

    // Verify the hashed password with the provided password
    if (hash('sha256', $password . $salt) === $hashedPassword) {
        // Generate and store user token
        $userToken = generaterndm(64);
        $_SESSION['user_token'] = $userToken;

        // Store user token in cookie with expiry time (e.g., 150 days) along with user type
        setcookie("user_token", $userToken, time() + (150 * 24 * 3600), "/");
        setcookie("user_type", $userType, time() + (150 * 24 * 3600), "/");

        if ($userType === 'admin') {
            $updateQuery = "UPDATE admins SET user_token = ? WHERE admin_id = ? OR username = ?";
        } else if ($userType === 'teacher') {
            $updateQuery = "UPDATE teachers SET user_token = ? WHERE teacher_id = ? OR username = ?";
        } else {
            $updateQuery = "UPDATE users SET user_token = ? WHERE student_id = ? OR username = ?";
        }

        $updateStmt = $conn->prepare($updateQuery);
        if ($updateStmt === false) {
            $_SESSION['errorMessages'] = ["Authentication failed: Token process failed."];
            header("Location: http://192.168.0.103/bob_offline/admin_login?$enKey&err_ey=$encryptionKey&error=token-update-failed");
            exit();
        }

        $updateStmt->bind_param("sss", $userToken, $row['id'], $row['username']);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirect based on user type
        if ($userType === 'admin') {
            header("Location: http://192.168.0.103/bob_offline/admin/?$enKey&type=admin&re_key=$encryptionKey");
            // Redirect to user page
            $_SESSION['successMessages'] = ["Login Successful."];
        } else if ($userType === 'teacher') {
            $_SESSION['successMessages'] = ["Login Successful."];
            header("Location: http://192.168.0.103/bob_offline/teacher/?$enKey&type=teacher&re_key=$encryptionKey");
        } else {
            $_SESSION['successMessages'] = ["Login Successful."];
            header("Location: https://examsite2.batb.io/user/?$enKey&type=user&re_key=$encryptionKey");
        }
        exit();
    } else {
        $_SESSION['errorMessages'] = ["Authentication failed: Invalid Password"];
        header("Location: http://192.168.0.103/bob_offline/admin_login?$enKey&err_ey=$encryptionKey&error=invalid-password-try-again");
        exit();
    }
} else {
    $_SESSION['errorMessages'] = ["Authentication failed: Invalid ID"];
    header("Location: http://192.168.0.103/bob_offline/admin_login?$enKey&err_ey=$encryptionKey&error=invalid-username-or-id-try-again");
    exit();
}
