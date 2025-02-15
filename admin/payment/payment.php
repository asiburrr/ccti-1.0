<?php
require '../../connection.php'; // Database connection
require '../session.php'; // Session management

// Initialize message arrays
$successMessages = isset($_SESSION['successMessages']) ? $_SESSION['successMessages'] : [];
$errorMessages = isset($_SESSION['errorMessages']) ? $_SESSION['errorMessages'] : [];

// Handle the payment form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $invid = $_POST['invid'];
    $course_id = $_POST['course_id'];
    $student_id = $_POST['student_id'];
    $paying_amount = $_POST['paying_amount'];
    $discount = $_POST['discount'];
    $method = $_POST['method'];

    if ($paying_amount < 0 || $discount < 0) {
        $_SESSION['errorMessages'][] = "Amount and Discount cannot be negative!";
    } else {
        $sql = "SELECT due_amount, student_id FROM payment WHERE invid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $invid);
        $stmt->execute();
        $result = $stmt->get_result();
        $payment = $result->fetch_assoc();

        if (!$payment) {
            $_SESSION['errorMessages'][] = "Payment record not found!";
        } else {
            $new_due_amount = $payment['due_amount'] - $paying_amount - $discount;

            if ($new_due_amount < 0) {
                $_SESSION['errorMessages'][] = 'Paying amount and discount cannot exceed the due amount!';
            } else {
                $sql = "UPDATE payment SET received_amount = received_amount + ?, discount = discount + ?, due_amount = ? WHERE invid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('iiis', $paying_amount, $discount, $new_due_amount, $invid);

                if ($stmt->execute()) {
                    // Generate a unique transaction ID (trxid)
                    $trxid = 'TRX' . time();

                    // Fetch full_name from users
                    $userQuery = "SELECT full_name FROM users WHERE student_id = ?";
                    $userStmt = $conn->prepare($userQuery);
                    $userStmt->bind_param('s', $student_id);
                    $userStmt->execute();
                    $userResult = $userStmt->get_result();
                    $user = $userResult->fetch_assoc();

                    if ($user) {
                        $full_name = $user['full_name'];

                        // Insert transaction details
                        $sql_history = "INSERT INTO payment_history (invid, student_id, course_id, amount, discount, trxid, method) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                        $stmt_history = $conn->prepare($sql_history);
                        $stmt_history->bind_param('siiiiss', $invid, $student_id, $course_id, $paying_amount, $discount, $trxid, $method);

                        if ($stmt_history->execute()) {
                            $_SESSION['successMessages'][] = "Payment successful. Roll: {$student_id}, Name: {$full_name}, Amount: {$paying_amount}, Discount: {$discount}";

                            // Redirect to payment data page with trxid
                            header("Location: ./?trxid={$trxid}&roll={$student_id}&name={$full_name}&amount={$paying_amount}&discount={$discount}");
                            exit();
                        } else {
                            $_SESSION['errorMessages'][] = "Transaction recording failed! Please try again.";
                        }
                    } else {
                        $_SESSION['errorMessages'][] = "Student record not found!";
                    }
                } else {
                    $_SESSION['errorMessages'][] = "Payment failed, please try again later.";
                }
            }
        }
    }
    header("Location: ./");
    exit();
}

?>
