<?php
require '../session.php';
require '../../connection.php';

// Retrieve form data
$studentID = $_POST['student_id'];
$fullName = $_POST['full_name'];
$gender = $_POST['gender'];
$phoneNumber = $_POST['phone_number'];
$edu_level = $_POST['edu_level'];
$institute = $_POST['institute'];

// Check if the student ID exists
$query_check_id = "SELECT * FROM users WHERE student_id = ?";
$stmt_check_id = $conn->prepare($query_check_id);
$stmt_check_id->bind_param("i", $studentID);
$stmt_check_id->execute();
$result_check_id = $stmt_check_id->get_result();

if ($result_check_id->num_rows === 0) {
    // If student ID does not exist, redirect with an error message
    $_SESSION['errorMessages'] = ['Invalid student ID.'];
    header("Location: ./");
    exit();
}

// Get the current student data
$query_get_student = "SELECT * FROM users WHERE student_id = ?";
$stmt_get_student = $conn->prepare($query_get_student);
$stmt_get_student->bind_param("i", $studentID);
$stmt_get_student->execute();
$result_get_student = $stmt_get_student->get_result();
$row_get_student = $result_get_student->fetch_assoc();

// Compare the retrieved data with the updated data
if ($row_get_student['full_name'] === $fullName &&
    $row_get_student['gender'] === $gender &&
    $row_get_student['phone_number'] === $phoneNumber &&
    $row_get_student['edu_level'] === $edu_level &&
    $row_get_student['institute'] === $institute) {
        $errorMessages[] = 'No changes detected.';
    $_SESSION['errorMessages'] = $errorMessages;
    header("Location: edit_student?student_id=$studentID");
    exit();
}

// Prepare the SQL query to update student data
$query = "UPDATE users SET full_name=?, gender=?, phone_number=?, edu_level=?, institute=? WHERE student_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssssi", $fullName, $gender, $phoneNumber, $edu_level, $institute, $studentID);
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows > 0) {
    $_SESSION['successMessages'] = ['Student updated successfully.'];
} else {
    $_SESSION['errorMessages'] = ['Failed to update student.'];
}

// Redirect back to the form page
header("Location: edit_student?student_id=$studentID");
exit();
?>
