<?php
session_start();
require 'connection.php';
function generateCsrfToken()
{
    return bin2hex(random_bytes(32));
}
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generateCsrfToken();
}

// Check if user token exists in session
if (isset($_SESSION['user_token'])) {
    $userToken = $_SESSION['user_token'];
    // Check if the user token exists in the users table
    $query = "SELECT admin_id FROM admins WHERE user_token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userToken);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!empty($student)) {
        // Token is valid for student, redirect to the student dashboard
        $_SESSION['successMessages'] = ["Logged in automatically."];
        header("Location: admin");
        exit();
    }

    // Token is invalid, unset the user_token session variable
    unset($_SESSION['user_token']);

    // Add error logging to see what's causing the issue
    $error_message = "Invalid user token found in session. Token: " . $userToken;
    error_log($error_message, 3, "error_log.txt");
}

// Check if user token exists in cookies
if (isset($_COOKIE['user_token'])) {
    $userToken = $_COOKIE['user_token'];

    // Check if the user token exists in the users table
    $query = "SELECT admin_id FROM admins WHERE user_token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userToken);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!empty($student)) {
        // Token is valid for student, redirect to the student dashboard
        $_SESSION['successMessages'] = ["Logged in automatically."];
        header("Location: admin");
        exit();
    }

    // Token is invalid, delete the cookie
    setcookie("user_token", "", time() - 3600, "/"); // delete cookie by setting expiry time in the past

    // Add error logging to see what's causing the issue
    $error_message = "Invalid user token found in cookies. Token: " . $userToken;
    error_log($error_message, 3, "error_log.txt");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Welcome to the Battles of Biology Exam System – BOB stands for Dedication. A seamless platform designed to help students test their knowledge and achieve academic and admission success.">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    <title>Admin - BOB Exam System</title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://examsite2.batb.io/admin_login">
    <meta property="og:title" content="Admin - BOB Exam System">
    <meta property="og:description" content="Welcome to the Battles of Biology Exam System – BOB stands for Dedication. A seamless platform designed to help students test their knowledge and achieve academic and admission success.">
    <meta property="og:image" content="https://examsite2.batb.io/uploads/Battles%20Of%20Biology.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://examsite2.batb.io/admin_login">
    <meta property="twitter:title" content="Admin - BOB Exam System">
    <meta property="twitter:description" content="Welcome to the Battles of Biology Exam System – BOB stands for Dedication. A seamless platform designed to help students test their knowledge and achieve academic and admission success.">
    <meta property="twitter:image" content="https://examsite2.batb.io/uploads/Battles%20Of%20Biology.png">
    <!-- Logo -->
    <link rel="logo" href="https://examsite2.batb.io/uploads/favicon-bob.png">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="https://examsite2.batb.io/uploads/favicon-bob.png">
    <link rel="icon" href="https://examsite2.batb.io/uploads/favicon-bob.png" type="image/png">
    <link rel="canonical" href="https://examsite2.batb.io/admin_login">

    <!-- Structured Data -->
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Article",
            "headline": "Admin - BOB Exam System",
            "description": "Welcome to the Battles of Biology Exam System – BOB stands for Dedication. A seamless platform designed to help students test their knowledge and achieve academic and admission success.",
            "author": {
                "@type": "Person",
                "name": "Sadiqur Rahman Sadab"
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        body {
            background-color: #F7F8FB;
            font-family: 'Roboto', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 380px;
            text-align: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .login-title {
            font-size: 40px;
            font-weight: bold;
            color: #00008b;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-control {
            border-radius: 50px;
            padding-left: 50px;
            font-size: 16px;
            height: 45px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
            transform: scale(1.05);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .btn-primary {
            background-color: #00008b;
            border-color: #00008b;
            font-size: 16px;
            border-radius: 50px;
            padding: 12px;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #0051a2;
            transform: translateY(-2px);
        }

        .login-btn-google {
            text-decoration: none;
            background-color: #000;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 50px;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .login-btn-google:hover {
            background-color: #ccc;
            transform: translateY(-2px);
        }

        .login-btn-google svg {
            width: 20px;
            height: 20px;
        }

        .divider {
            position: relative;
            margin: 20px 0;
            text-align: center;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            border-top: 1px solid #ddd;
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .divider span {
            position: relative;
            font-size: 14px;
            color: #777;
            padding: 0 10px;
            background-color: #fff;
        }

        .forgot-password {
            font-size: 14px;
            margin-top: 15px;
            color: #00008b;
        }

        .forgot-password a {
            color: #00008b;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .note {
            margin-top: 15px;
            font-size: 12px;
            color: #888;
        }

        .note span {
            font-weight: bold;
            color: #00008b;
        }

        .loading {
            display: none;
            margin-left: 10px;
        }

        .alert {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        @media (min-width: 300px) and (max-width: 767px) {
            body {
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="login-title"><i class="fas fa-lock"></i> Admin</h2>
        <!-- Alert Messages -->
        <div id="alertBox" class="alert" role="alert"></div>
        <form action="auth/authentication" method="post">
            <input type="hidden" name="user_type" value="admin">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="mb-3 form-group">
                <i class="fas fa-user input-icon"></i>
                <input type="number" class="form-control" name="username" placeholder="Enter your Admin ID" required>
            </div>
            <div class="mb-3 form-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" class="form-control" name="password" placeholder="Enter your Password" required>
            </div>
            <button type="submit" id="submitBtn" class="btn btn-primary w-100 mb-3">
                Log In
            </button>
        </form>
    </div>
    <!-- Bootstrap Toasts -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <!-- Toasts for Success Messages -->
        <?php if (!empty($_SESSION['successMessages'])) : ?>
            <?php foreach ($_SESSION['successMessages'] as $successMessage) : ?>
                <div class="toast bg-success text-white animate__animated animate__fadeInRight" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?php echo $successMessage; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['successMessages']); ?>
        <?php endif; ?>
        <!-- Toasts for Error Messages -->
        <?php if (!empty($_SESSION['errorMessages'])) : ?>
            <?php foreach ($_SESSION['errorMessages'] as $errorMessage) : ?>
                <div class="toast bg-danger text-white animate__animated animate__fadeInRight" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Error</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <?php echo $errorMessage; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['errorMessages']); ?>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Initialize Toasts -->
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        });
        toastList.forEach(function(toast) {
            toast.show();
        });
    </script>
</body>

</html>