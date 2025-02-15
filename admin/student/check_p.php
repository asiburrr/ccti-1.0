<?php
include '../../connection.php';

$phone = $_GET['phone'] ?? '';
$currentStudentId = $_GET['student_id'] ?? ''; // Assuming `student_id` is passed

$response = ['exists' => false];

if (!empty($phone)) {
    // Query to check phone number, excluding the current student's ID
    $query = "SELECT student_id FROM users WHERE phone_number = ? AND student_id != ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $phone, $currentStudentId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['exists'] = true;
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
