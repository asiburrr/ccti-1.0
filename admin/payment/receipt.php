<?php
require '../../connection.php'; // Database connection
require '../../vendor/autoload.php'; // Include FPDI and FPDF

use setasign\Fpdi\Fpdi;

// Retrieve transaction ID from the URL
$trxid = $_GET['trxid'] ?? '';

if (!$trxid) {
    die('Transaction ID is required.');
}

// Fetch payment information from the database
$sql = "SELECT 
            ph.amount AS payment, 
            ph.method AS payment_method, 
            ph.timestamp AS payment_time, 
            u.full_name AS name, 
            u.institute,
            u.session,
            u.phone_number, 
            u.father_name,
            u.student_id AS roll, 
            c.name AS course_name, 
            c.start_time,
            c.end_time
        FROM payment_history ph
        INNER JOIN users u ON ph.student_id = u.student_id
        INNER JOIN course c ON ph.course_id = c.course_id
        WHERE ph.trxid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $trxid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Invalid transaction ID.');
}

$data = $result->fetch_assoc();

// Define placeholder data
$placeholders = [
    '${name}' => $data['name'],
    '${institute}' => $data['institute'],
    '${session}' => $data['session'],
    '${phone_number}' => $data['phone_number'],
    '${father_name}' => $data['father_name'],
    '${course_name}' => $data['course_name'],
    '${start_time} - ${end_time}' => $data['start_time'] . ' - ' . $data['end_time'],
    '${payment}' => $data['payment'] . ' BDT',
    '${payment_method}' => $data['payment_method'],
    '${payment_time}' => $data['payment_time'],
];


// Coordinates for each placeholder
$coordinates = [
    '${name}' => [32, 56],
    '${institute}' => [36, 70],
    '${session}' => [49, 84],
    '${phone_number}' => [141, 84],
    '${father_name}' => [55, 98],
    '${course_name}' => [52, 129],
    '${start_time} - ${end_time}' => [46, 143],
    '${payment}' => [70, 157],
    '${payment_method}' => [62, 171],
    '${payment_time}' => [56, 184],
];

// Load the PDF template
$pdf = new Fpdi();
$templatePath = 'template/Receipt.pdf';

$pdf->AddPage();
$pdf->setSourceFile($templatePath);
$templateId = $pdf->importPage(1);
$pdf->useTemplate($templateId);

// Add placeholder data to the PDF
$pdf->SetFont('Arial', '', 15);
$pdf->SetTextColor(0, 0, 0);

foreach ($placeholders as $key => $value) {
    if (isset($coordinates[$key])) {
        [$x, $y] = $coordinates[$key];
        $pdf->SetXY($x, $y);
        $pdf->Write(10, $value);
    }
}

// Output the PDF
$filename = 'receipt_' . $trxid . '.pdf';
$pdf->Output('I', $filename);
