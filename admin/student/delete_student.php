<?php
require '../../connection.php';
require '../session.php';


// Validate and sanitize student ID
$studentID = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
if ($studentID <= 0) {
    // Invalid or missing student ID
    $_SESSION['errorMessages'] = ['Invalid student ID.'];
    header("Location: ./");
    exit();
}

// Perform the database query to delete the student data
$query = "DELETE FROM users WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $studentID);
$stmt->execute();

// Check if the deletion was successful
if ($stmt->affected_rows > 0) {
    // Student deleted successfully
    $_SESSION['successMessages'] = ['Student deleted successfully.'];
} else {
    // Failed to delete student
    $_SESSION['errorMessages'] = ['Failed to delete student.'];
}

// Redirect back to the form page
header("Location: ./");
exit();
?>
