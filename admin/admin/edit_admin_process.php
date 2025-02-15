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

// Retrieve form data
$adminID = $_POST['admin_id'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$fullName = $_POST['full_name'];
$role = $_POST['role'];
$email = $_POST['email'];
$phoneNumber = $_POST['phone_number'];


// Check if the admin ID exists
$query_check_id = "SELECT * FROM admins WHERE admin_id = ?";
$stmt_check_id = $conn->prepare($query_check_id);
$stmt_check_id->bind_param("i", $adminID);
$stmt_check_id->execute();
$result_check_id = $stmt_check_id->get_result();

if ($result_check_id->num_rows === 0) {
    // If admin ID does not exist, redirect with an error message
    $_SESSION['errorMessages'] = ['Invalid admin ID.'];
    header("Location: ./");
    exit();
}

// Get the current admin data
$query_get_admin = "SELECT * FROM admins WHERE admin_id = ?";
$stmt_get_admin = $conn->prepare($query_get_admin);
$stmt_get_admin->bind_param("i", $adminID);
$stmt_get_admin->execute();
$result_get_admin = $stmt_get_admin->get_result();
$row_get_admin = $result_get_admin->fetch_assoc();

// Compare the retrieved data with the updated data
if ($row_get_admin['first_name'] === $firstName &&
    $row_get_admin['last_name'] === $lastName &&
    $row_get_admin['full_name'] === $fullName &&
    $row_get_admin['role'] === $role &&
    $row_get_admin['email'] === $email &&
    $row_get_admin['phone_number'] === $phoneNumber) {
        $errorMessages[] = 'No changes detected.';
    $_SESSION['errorMessages'] = $errorMessages;
    header("Location: edit_admin?admin_id=$adminID");
    exit();
}

// Prepare the SQL query to update admin data
$query = "UPDATE admins SET first_name=?, last_name=?, full_name=?, role=?, email=?, phone_number=? WHERE admin_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssi", $firstName, $lastName, $fullName, $role, $email, $phoneNumber, $adminID);
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows > 0) {
    $_SESSION['successMessages'] = ['Admin updated successfully.'];
} else {
    $_SESSION['errorMessages'] = ['Failed to update admin.'];
}

// Redirect back to the form page
header("Location: edit_admin?admin_id=$adminID");
exit();
?>
