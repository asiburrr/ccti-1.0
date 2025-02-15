<?php
require 'vendor/autoload.php'; // Load the libraries

use setasign\Fpdi\Fpdi;

// Placeholder values
$data = [
    '${name}' => 'example',
    '${college}' => 'xyz college',
    '${hsc_session}' => '2019-2021',
    '${guardian_name}' => 'example',
    '${phone_number}' => '017700000000',
    '${course_name}' => 'Nothing',
    '${batch_time}' => '11:00 - 12:00',
    '${payment}' => '5000 BDT',
    '${payment_method}' => 'Bkash',
    '${payment_time}' => '2024-12-11 18:01:23',
];

// Coordinates for each placeholder
$coordinates = [
    '${name}' => [32, 56],
    '${college}' => [36, 70],
    '${hsc_session}' => [49, 84],
    '${phone_number}' => [141, 84],
    '${guardian_name}' => [55, 98],
    '${course_name}' => [52, 129],
    '${batch_time}' => [46, 143],
    '${payment}' => [70, 157],
    '${payment_method}' => [62, 171],
    '${payment_time}' => [56, 184],
];

// Initialize FPDI
$pdf = new Fpdi();
$templateFile = 'Receipt.pdf';
$pdf->setSourceFile($templateFile);

// Import the first page of the template
$templateId = $pdf->importPage(1);
$pageSize = $pdf->getTemplateSize($templateId);

// Add a page and apply the template
$pdf->AddPage($pageSize['orientation'], [$pageSize['width'], $pageSize['height']]);
$pdf->useTemplate($templateId);

// Set font and text color
$pdf->SetFont('Arial', '', 14);
$pdf->SetTextColor(0, 0, 0);

// Write the data to the PDF
foreach ($data as $placeholder => $value) {
    if (isset($coordinates[$placeholder])) {
        [$x, $y] = $coordinates[$placeholder];
        $pdf->SetXY($x, $y);
        $pdf->Write(10, $value); // Replace the placeholder with actual text
    }
}

// Output the final PDF
$outputFile = 'output.pdf'; // Path to save the final PDF
$pdf->Output($outputFile, 'F');

echo "PDF with details saved as $outputFile.";
?>
