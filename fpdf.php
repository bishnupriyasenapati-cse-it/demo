<?php

// Include FPDF library for PDF generation
require('fpdf186/fpdf.php');

// Include database connection file (PDO)
require('db.php');

// Create new PDF document
$pdf = new FPDF();

// Add a new page to the PDF
$pdf->AddPage();

// Set font: Arial, Bold, size 14
$pdf->SetFont('Arial','B',14);

// Create title cell (width 190, height 10, bordered, centered)
$pdf->Cell(190,10,'Member List',1,1,'C');

// Set font for table headers
$pdf->SetFont('Arial','B',12);

// Table Header
$pdf->Cell(30,10,'ID',1);        // Column for ID
$pdf->Cell(80,10,'Name',1);      // Column for Name
$pdf->Cell(80,10,'Email',1);     // Column for Email
$pdf->Ln();                      // Move to next line

// ✅ Fetch data using PDO
$stmt = $pdo->query("SELECT * FROM members");

// Set font for table data
$pdf->SetFont('Arial','',12);

// Loop through each row from database
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    // Output each column value into PDF cells
    $pdf->Cell(30,10,$row['id'],1);       // ID column
    $pdf->Cell(80,10,$row['name'],1);     // Name column
    $pdf->Cell(80,10,$row['email'],1);    // Email column
    
    $pdf->Ln(); // Move to next row
}

// 🔥 FORCE DOWNLOAD of the generated PDF file
$pdf->Output('D', 'member_list.pdf');

?>