<?php
require 'vendor/autoload.php';

use setasign\Fpdi\Fpdi;

$pdf = new Fpdi();
$pdf->setSourceFile('Receipt.pdf');

// Import the first page
$pageId = $pdf->importPage(1);
$pageSize = $pdf->getTemplateSize($pageId);

$pdf->AddPage($pageSize['orientation'], [$pageSize['width'], $pageSize['height']]);
$pdf->useTemplate($pageId);

// Add a grid for manual inspection
$pdf->SetFont('Arial', '', 8);
for ($x = 0; $x <= $pageSize['width']; $x += 10) {
    $pdf->SetXY($x, 0);
    $pdf->Write(5, $x);
    $pdf->Line($x, 0, $x, $pageSize['height']);
}
for ($y = 0; $y <= $pageSize['height']; $y += 10) {
    $pdf->SetXY(0, $y);
    $pdf->Write(5, $y);
    $pdf->Line(0, $y, $pageSize['width'], $y);
}

// Output the grid-enabled PDF
$pdf->Output('grid_overlay.pdf', 'F');
echo "Grid overlay PDF created as grid_overlay.pdf.";
?>
