<?php
require('fpdf186/fpdf.php'); // Include the FPDF library to generate PDF

// ================= SECURITY =================
// Function to clean input values to prevent HTML injection
function clean($v){
    return htmlspecialchars(trim($v));
}

// ================= GET DATA =================
// Fetch data from GET request, provide defaults if not set
$name = strtoupper(clean($_GET['name'] ?? 'Employee')); // Convert name to uppercase
$type = clean($_GET['type'] ?? 'staff'); // Employee type

$position = ($type == 'trainer')
    ? 'Fitness Trainer' // Default title for trainer
    : clean($_GET['position'] ?? 'Staff'); // Default for other staff

$salary = clean($_GET['salary'] ?? '20000'); // Default salary
$joining_date = clean($_GET['joining_date'] ?? date("d M Y")); // Default joining date is today

// ================= PDF INITIALIZATION =================
$pdf = new FPDF();
$pdf->AddPage(); // Add a new page

// ================= HEADER =================
$pdf->SetFillColor(0,102,204); // Blue header background
$pdf->Rect(0,0,210,20,'F'); // Draw filled rectangle for header

$pdf->SetTextColor(255,255,255); // White text
$pdf->SetFont('Arial','B',16);
$pdf->SetY(6); // Position from top
$pdf->Cell(0,8,'FitZone Gym',0,1,'C'); // Gym name in header

$pdf->SetTextColor(0,0,0); // Reset text color to black

$pdf->Ln(10); // Line break
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,5,'Transforming Strength into Lifestyle',0,1,'C'); // Gym tagline

$pdf->SetDrawColor(0,102,204); // Line color
$pdf->Line(10,30,200,30); // Draw horizontal line under header

$pdf->Ln(10);

// ================= DATE =================
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,10,'Date: '.date('d M Y'),0,1,'R'); // Current date on top-right

// ================= TITLE =================
$pdf->SetFont('Arial','B',18);
$pdf->Cell(0,10,'JOINING LETTER',0,1,'C'); // Main title

$pdf->Ln(5);

// ================= INFO BOX =================
$pdf->SetFillColor(240,240,240); // Light gray background
$pdf->Rect(10,60,190,30,'F'); // Draw filled rectangle for employee info

$pdf->SetXY(15,65); // Set position inside box
$pdf->SetFont('Arial','',11);

$pdf->Cell(90,8,"Name: $name",0,0); // Employee name
$pdf->Cell(90,8,"Position: $position",0,1); // Position

$pdf->Cell(90,8,"Joining Date: $joining_date",0,0); // Joining date
$pdf->Cell(90,8,"Salary: Rs. $salary",0,1); // Salary

$pdf->Ln(15);

// ================= BODY =================
$pdf->SetFont('Arial','',12);

// Main letter content
$text = "Dear $name,\n\n"
      ."We are pleased to appoint you as $position at FitZone Gym.\n\n"
      ."Your joining date will be $joining_date with a monthly salary of Rs. $salary.\n\n"
      ."You are expected to maintain professionalism and follow company policies.\n\n"
      ."We welcome you to our team and wish you success.\n\n"
      ."Best Regards,\nFitZone Gym";

$pdf->MultiCell(0,8,$text);

// ================= SIGNATURE =================
$pdf->Ln(15);

$pdf->Cell(90,10,'Employee Signature','T',0,'C'); // Left signature line
$pdf->Cell(90,10,'Authorized Signature','T',1,'C'); // Right signature line

// ================= FOOTER =================
$pdf->SetY(-20); // 20mm from bottom
$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,10,'FitZone Gym | Bangalore | Contact: +91 9876543210',0,0,'C'); // Footer info

// ================= OUTPUT =================
$pdf->Output(); // Send PDF to browser
?>