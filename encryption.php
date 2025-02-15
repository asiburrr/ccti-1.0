<?php
// Start or resume the session
session_start();

// Function to generate a random encryption key
function generateRandomKey($length = 32) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $randomKey = '';

    // Ensure the first character is a letter
    $randomKey .= $characters[rand(10, 51)]; // 10 is the index of 'a', and 51 is the index of 'Z'

    for ($i = 1; $i < $length; $i++) {
        $randomKey .= $characters[rand(0, $charactersLength - 1)];
    }

    // Store the encryption key and timestamp in the session
    $_SESSION['encryptionKey'] = $randomKey;
    $_SESSION['encryptionKeyTimestamp'] = time(); // Store the current timestamp

    return $randomKey;
}

// Check if the encryption key is set and not expired
if (!isset($_SESSION['encryptionKey']) || (time() - $_SESSION['encryptionKeyTimestamp'] > 30)) {
    // Generate a new encryption key if not set or expired
    $encryptionKey = generateRandomKey(16);
} else {
    // Use the existing encryption key
    $encryptionKey = $_SESSION['encryptionKey'];
}
?>
