<?php
include '../../connection.php';

$phone = $_GET['phone'] ?? '';

$response = ['exists' => false];

if (!empty($phone)) {
    $query = "SELECT student_id FROM users WHERE phone_number = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $response['exists'] = true;
    }
}

echo json_encode($response);
?>
