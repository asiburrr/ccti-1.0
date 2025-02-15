<?php
require '../../connection.php';
require '../session.php';

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
        if ($role === 'administration') {

        } else {
            // Admin does not have the correct role, redirect with error message
            $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
            header("Location: ../");
            exit();
        }
    } else {
        // Admin not found, redirect with error message
        $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
        header("Location: ../");
        exit();
    }
} else {
    // admin_id not set in session, redirect with error message
    $_SESSION['errorMessages'] = ['You don\'t have access to view this page.'];
    header("Location: ../");
    exit();
}

// Retrieve the last student ID from the admins table
$sql = "SELECT MAX(admin_id) AS lastID FROM admins";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$lastID = $row['lastID'];

// Generate the new student ID
$newID = $lastID >= 1001 ? $lastID + 1 : 1001;

// Generate random password
$password = mt_rand(100000, 999999);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #00008B;
            margin: 10px;

        }

        .container {
            max-width: 550px;
            margin: 10px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }


        h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #00008B;
            font-weight: bold;
        }

        .line {
            display: flex;
            padding: 1px;
            margin-bottom: 10px;
            background-color: #00008B;
        }

        label {
            font-weight: 700;
            color: #00008B;
        }

        .form-control {
            border-radius: 20px;
            padding: 12px;
            margin-bottom: 0px;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #00008B;
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #1a3944;
        }

        select.custom-select {
            border-radius: 20px;
            padding: 8px;
            box-shadow: none;
        }

        .fa-asterisk {
            color: red;
            font-size: 14px;
        }
    </style>
    <title>Add Admin</title>
</head>

<body>
    <?php include '../nav.php'; ?>
    <div class="content">
        <div class="container">
            <h2>Add Admin</h2>
            <div class="line"></div>
            <form id="form" action="add_admin_process.php" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="admin_id">Generated id <i class="fas fa-asterisk"></i></label>
                        <input type="number" class="form-control" id="admin_id" name="admin_id" value="<?php echo $newID; ?>" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="password" name="password" value="<?php echo $password; ?>" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="first_name" placeholder="Enter first name" name="first_name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="last_name" placeholder="Enter last name" name="last_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="full_name">Full Name <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" readonly required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="username">Username <i class="fas fa-asterisk"></i></label>
                        <input type="text" class="form-control" id="username" name="username" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Email <i class="fas fa-asterisk"></i></label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email address" name="email" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone_number">Phone Number <i class="fas fa-asterisk"></i></label>
                        <input type="tel" class="form-control" id="phone_number" placeholder="Enter phone number" name="phone_number" pattern="[0-9]{11}" title="Please enter 11 digits phone number" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
        </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var firstNameInput = document.getElementById('first_name');
            var lastNameInput = document.getElementById('last_name');
            var fullNameInput = document.getElementById('full_name');

            function updateFullName() {
                var firstName = firstNameInput.value.trim();
                var lastName = lastNameInput.value.trim();
                fullNameInput.value = firstName + ' ' + lastName;
            }

            firstNameInput.addEventListener('input', updateFullName);
            lastNameInput.addEventListener('input', updateFullName);
        });
        document.addEventListener('DOMContentLoaded', function() {
            var firstNameInput = document.getElementById('first_name');
            var studentIdInput = document.getElementById('admin_id');
            var usernameInput = document.getElementById('username');

            function updateUsername() {
                var firstName = firstNameInput.value.trim().toLowerCase().replace(/\s+/g, '');
                var studentId = studentIdInput.value.trim();
                usernameInput.value = firstName + studentId;
            }

            firstNameInput.addEventListener('input', updateUsername);
            studentIdInput.addEventListener('input', updateUsername);
        });
    </script>

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