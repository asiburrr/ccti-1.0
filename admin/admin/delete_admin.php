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

// Validate and sanitize admin ID
$adminID = isset($_GET['admin_id']) ? intval($_GET['admin_id']) : 0;
if ($adminID <= 0) {
    // Invalid or missing admin ID
    $_SESSION['errorMessages'] = ['Invalid admin ID.'];
    header("Location: ./");
    exit();
}

// Perform the database query to delete the admin data
$query = "DELETE FROM admins WHERE admin_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $adminID);
$stmt->execute();

// Check if the deletion was successful
if ($stmt->affected_rows > 0) {
    // admin deleted successfully
    $_SESSION['successMessages'] = ['Admin deleted successfully.'];
} else {
    // Failed to delete admin
    $_SESSION['errorMessages'] = ['Failed to delete admin.'];
}

// Redirect back to the form page
header("Location: ./");
exit();
?>
