<?php
require '../../connection.php';
require '../session.php';
require_once('vendor/autoload.php');

use ElasticEmail\Configuration;
use ElasticEmail\Api\EmailsApi;
use ElasticEmail\Model\EmailMessageData;
use ElasticEmail\Model\EmailRecipient;
use ElasticEmail\Model\EmailContent;
use ElasticEmail\Model\BodyPart;

// Check if admin_id is set in session
if (isset($_SESSION['username'])) {
    $admin_id = $_SESSION['username'];

    // Prepare SQL query to get the admin's role
    $sql = "SELECT role FROM admins WHERE admin_id = ? OR username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $admin_id, $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if admin is found
    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        $role = $admin['role'];

        // Check the role
        if ($role !== 'administration') {
            $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
            header("Location: ../");
            exit();
        }
    } else {
        $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
        header("Location: ../");
        exit();
    }
} else {
    $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
    header("Location: ../");
    exit();
}

// Function to generate a random salt
function generateSalt() {
    $length = 32; // Salt length
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $salt = '';
    for ($i = 0; $i < $length; $i++) {
        $salt .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $salt;
}

// Retrieve form data
$admin_id = $_POST['admin_id'];
$username = $_POST['username'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$salt = generateSalt(); // Generate salt
$hashedPassword = hash('sha256', $password . $salt);

$role = 'admin';

// Prepare and execute the SQL query to insert data into the database
$sql = "INSERT INTO admins (admin_id, role, username, email, phone_number, first_name, last_name, full_name, password, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $admin_id, $role, $username, $email, $phone_number, $first_name, $last_name, $full_name, $hashedPassword, $salt);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $successMessages[] = 'Admin added successfully.';
    
    // Now send the email notification
    sendRegistrationEmail($email, $full_name, $username, $admin_id, $password);
    
} else {
    $errorMessages[] = 'Admin added failed.!';
}

$_SESSION['successMessages'] = $successMessages;
$_SESSION['errorMessages'] = $errorMessages;

// Redirect back to the form page
header("Location: add_admin");
exit();
$stmt->close();
$conn->close();


// Function to send registration email with Elastic Email API
function sendRegistrationEmail($toEmail, $fullName, $username, $adminId, $password)
{
    // Setup API Key
    $config = Configuration::getDefaultConfiguration()
        ->setApiKey('X-ElasticEmail-ApiKey', '8C3B92E48B2083857DDD9EFBDEE9304AD72E298F92CF30BD7105A1DEEDA783B8437C2E085F1EFAB7037E1C8D93C0425C'); // Replace with your actual API Key

    // Create an instance of EmailsApi
    $apiInstance = new EmailsApi(
        new GuzzleHttp\Client(),
        $config
    );

    // Load the HTML template content
    $emailTemplate = file_get_contents('register_email.html');

    $emailContent = str_replace(
        ['{{full_name}}', '{{username}}', '{{admin_id}}', '{{password}}'],
            [$fullName, $username, $adminId, $password],
        $emailTemplate
    );

    // Email details
    $email = new EmailMessageData([
        "recipients" => [
            new EmailRecipient(["email" => $toEmail])
        ],
        "content" => new EmailContent([
            "body" => [
                new BodyPart([
                    "content_type" => "HTML",
                    "content" => $emailContent
                ])
            ],
            "from" => "examsite2@batb.io",
            "subject" => "Registration Confirmation"
        ])
    ]);

    try {
        // Send email via Elastic Email API
        $apiInstance->emailsPost($email);
        echo "Email sent successfully!";
    } catch (Exception $e) {
        // Log the error message to the log file
        logEmailError($e->getMessage());
        echo 'Exception when calling ElasticEmail API: ', $e->getMessage(), PHP_EOL;
    }
}

// Function to log email errors
function logEmailError($errorMessage)
{
    $logFile = 'email_error.log';
    if (!file_exists($logFile)) {
        file_put_contents($logFile, "Email Error Log\n\n", FILE_APPEND);
    }

    // Log the error message with a timestamp
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] Error: {$errorMessage}\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

?>
