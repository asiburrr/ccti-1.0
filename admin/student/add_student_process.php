<?php
require '../../connection.php';
require '../session.php';

// Retrieve form data and sanitize inputs
$student_id = filter_input(INPUT_POST, 'student_id', FILTER_SANITIZE_STRING);
$first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
$last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
$full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
$phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);
$gpa = filter_input(INPUT_POST, 'gpa', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$reg = filter_input(INPUT_POST, 'reg', FILTER_SANITIZE_STRING);
$institute = filter_input(INPUT_POST, 'institute', FILTER_SANITIZE_STRING);
$session = filter_input(INPUT_POST, 'session', FILTER_SANITIZE_STRING);
$father_name = filter_input(INPUT_POST, 'father_name', FILTER_SANITIZE_STRING);
$father_number = filter_input(INPUT_POST, 'father_number', FILTER_SANITIZE_STRING);
$course = filter_input(INPUT_POST, 'course', FILTER_SANITIZE_NUMBER_INT);

$successMessages = [];
$errorMessages = [];

try {
    // Start transaction
    $conn->begin_transaction();

    // Insert user data into the `users` table
    $sql = "INSERT INTO users (student_id, phone_number, first_name, last_name, full_name, institute, session, gpa, reg, father_name, father_number) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $student_id, $phone_number, $first_name, $last_name, $full_name, $institute, $session, $gpa, $reg, $father_name, $father_number);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $successMessages[] = 'Student added successfully. (Roll: ' . $student_id . ')';

        // Check if the course exists and retrieve the fee
        $courseCheckQuery = "SELECT course_id, fee FROM course WHERE course_id = ?";
        $courseCheckStmt = $conn->prepare($courseCheckQuery);
        $courseCheckStmt->bind_param("i", $course);
        $courseCheckStmt->execute();
        $courseCheckResult = $courseCheckStmt->get_result();

        if ($courseCheckResult->num_rows > 0) {
            $courseData = $courseCheckResult->fetch_assoc();
            $fee = $courseData['fee'];

            // Insert into the `enrollment` table
            $enrollQuery = "INSERT INTO enrollment (course_id, student_id) VALUES (?, ?)";
            $enrollStmt = $conn->prepare($enrollQuery);
            $enrollStmt->bind_param("ii", $course, $student_id);
            $enrollStmt->execute();

            if ($enrollStmt->affected_rows > 0) {
                $successMessages[] = 'Enrollment successful.';

                // Generate a unique `invid` (Invoice ID)
                $invid = 'INV' . time();

                // Check if the `invid` already exists
                $checkInvidQuery = "SELECT COUNT(*) FROM payment WHERE invid = ?";
                $checkInvidStmt = $conn->prepare($checkInvidQuery);
                $checkInvidStmt->bind_param("s", $invid);
                $checkInvidStmt->execute();
                $checkInvidResult = $checkInvidStmt->get_result();
                $invidExists = $checkInvidResult->fetch_row()[0] > 0;

                // If `invid` exists, regenerate it
                if ($invidExists) {
                    $invid = 'INV' . time() . rand(100, 999); // Adding a random number
                }

                // Insert into the `payment` table
                $paymentQuery = "INSERT INTO payment (invid, student_id, course_id, amount, due_amount, received_amount, discount) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?)";
                $paymentStmt = $conn->prepare($paymentQuery);
                $received_amount = 0; // Set received_amount to 0
                $discount = 0; // Set discount to 0
                $paymentStmt->bind_param("siidddi", $invid, $student_id, $course, $fee, $fee, $received_amount, $discount);
                $paymentStmt->execute();

                if ($paymentStmt->affected_rows > 0) {
                    $successMessages[] = 'Payment record created successfully. Invoice ID: ' . $invid;
                } else {
                    $errorMessages[] = 'Failed to create payment record.';
                }

                $paymentStmt->close();
            } else {
                $errorMessages[] = 'Enrollment failed.';
            }

            $enrollStmt->close();
        } else {
            $errorMessages[] = 'Course not found.';
        }

        $courseCheckStmt->close();
    } else {
        $errorMessages[] = 'Failed to add student.';
    }

    // Commit transaction if no errors
    if (empty($errorMessages)) {
        $conn->commit();
    } else {
        $conn->rollback();
    }
} catch (Exception $e) {
    // Rollback on exception
    $conn->rollback();
    $errorMessages[] = 'An error occurred: ' . $e->getMessage();
}

// Store messages in the session
$_SESSION['successMessages'] = $successMessages;
$_SESSION['errorMessages'] = $errorMessages;

// Redirect back to the form page with appropriate messages
header("Location: add_student");
exit();

// Close resources
$stmt->close();
$conn->close();
?>
