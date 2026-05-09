<?php
// Start session to track admin login
session_start();

// ================= AUTH CHECK =================
// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Include TCPDF library for PDF generation
require_once('TCPDF-main/tcpdf.php');

// ================= SECURITY FUNCTION =================
// Sanitize user input to prevent XSS attacks
function clean($value) {
    return htmlspecialchars(trim($value));
}

// ================= INPUT HANDLING =================
// Get certificate type (default: member)
$type = isset($_GET['type']) ? clean($_GET['type']) : 'member';

// ================= DATA PREPARATION =================
// Collect and prepare certificate data
$data = [
    "gym_name" => "FitZone Gym",
    "tagline" => "Transforming Strength into Lifestyle",

    // Convert name to uppercase
    "name" => strtoupper(clean($_GET['name'] ?? 'User')),

    "program" => clean($_GET['program'] ?? 'Fitness Program'),
    "duration" => "12 Weeks",
    "trainer" => clean($_GET['trainer'] ?? 'Trainer'),

    // Static demo values (can be dynamic later)
    "attendance" => "90%",
    "weight_change" => "-5 kg",
    "bmi_change" => "-1.5",

    // Unique certificate ID generation
    "cert_id" => "GYM-" . date("Ymd") . "-" . strtoupper(substr(uniqid(), -4)),

    // Current date
    "date" => date("d M Y"),

    // Trainer-specific fields
    "level" => "Advanced",
    "specialization" => "Fitness"
];

// ================= CUSTOM PDF CLASS =================
class PDF extends TCPDF {

    public $gym_name;
    public $tagline;

    // Override header method
    public function Header() {

        // Display logo if exists
        if(file_exists('images/logo.png')) {
            $this->Image('images/logo.png', 20, 10, 20);
        }

        // Gym name (centered)
        $this->SetFont('helvetica', 'B', 18);
        $this->Cell(0, 10, $this->gym_name, 0, 1, 'C');

        // Tagline below gym name
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, $this->tagline, 0, 1, 'C');

        $this->Ln(5);
    }
}

// ================= CREATE PDF INSTANCE =================
$pdf = new PDF('L', 'mm', 'A4');

// Assign header values
$pdf->gym_name = $data['gym_name'];
$pdf->tagline = $data['tagline'];

// Page settings
$pdf->SetMargins(15, 35, 15);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

// ================= BACKGROUND DESIGN =================

// Light background
$pdf->SetFillColor(245, 245, 245);
$pdf->Rect(10, 10, 277, 190, 'F');

// Top blue header bar
$pdf->SetFillColor(0, 102, 204);
$pdf->Rect(10, 10, 277, 20, 'F');

// Header text
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->SetXY(10, 14);
$pdf->Cell(277, 10, 'OFFICIAL FITNESS CERTIFICATE', 0, 1, 'C');

// Reset text color
$pdf->SetTextColor(0,0,0);

// Outer border
$pdf->SetDrawColor(180, 180, 180);
$pdf->SetLineWidth(1);
$pdf->Rect(10, 10, 277, 190);

// Inner border
$pdf->SetDrawColor(220, 220, 220);
$pdf->Rect(15, 15, 267, 180);

// ================= CERTIFICATE TITLE =================
$pdf->Ln(15);
$pdf->SetFont('times', 'B', 26);

// Dynamic title based on type
$title = ($type == "trainer")
    ? "CERTIFIED FITNESS TRAINER"
    : "CERTIFICATE OF ACHIEVEMENT";

$pdf->Cell(0, 15, $title, 0, 1, 'C');

// ================= USER NAME =================
$pdf->SetFont('times', 'B', 28);
$pdf->SetTextColor(0, 102, 204);
$pdf->Cell(0, 15, $data['name'], 0, 1, 'C');

// Decorative line under name
$pdf->SetDrawColor(0,102,204);
$pdf->Line(100, 85, 200, 85);

// Reset text
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('times', '', 14);

// Subtitle based on type
$subtitle = ($type == "trainer")
    ? "is officially recognized as a certified professional trainer"
    : "has successfully completed the fitness transformation program";

$pdf->Cell(0, 10, $subtitle, 0, 1, 'C');

$pdf->Ln(5);

// ================= DETAILS SECTION =================
$pdf->SetFont('helvetica', '', 12);

// Trainer certificate details
if($type == "trainer") {

    $html = "
    <table cellpadding='8'>
        <tr>
            <td><b>Level:</b> {$data['level']}</td>
            <td><b>Specialization:</b> {$data['specialization']}</td>
        </tr>
        <tr>
            <td><b>ID:</b> {$data['cert_id']}</td>
            <td><b>Date:</b> {$data['date']}</td>
        </tr>
    </table>
    ";

} else {

    // Member certificate details
    $html = "
    <table cellpadding='8'>
        <tr>
            <td><b>Program:</b> {$data['program']}</td>
            <td><b>Duration:</b> {$data['duration']}</td>
        </tr>
        <tr>
            <td><b>Trainer:</b> {$data['trainer']}</td>
            <td><b>Attendance:</b> {$data['attendance']}</td>
        </tr>
        <tr>
            <td><b>Weight Change:</b> {$data['weight_change']}</td>
            <td><b>BMI Change:</b> {$data['bmi_change']}</td>
        </tr>
    </table>
    ";
}

// Render HTML table
$pdf->writeHTML($html, true, false, true, false, 'C');

// ================= PROGRESS BAR =================
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, 'Fitness Progress', 0, 1, 'C');

// Background bar
$pdf->SetFillColor(200,200,200);
$pdf->Rect(80, 120, 120, 6, 'F');

// Progress fill (example: 75%)
$pdf->SetFillColor(0, 200, 83);
$pdf->Rect(80, 120, 90, 6, 'F');

// ================= CERTIFICATE ID BOX =================
$pdf->SetFillColor(240,240,240);
$pdf->Rect(20, 120, 50, 25, 'F');

$pdf->SetXY(20, 122);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->MultiCell(50, 5, "CERT ID\n".$data['cert_id'], 0, 'C');

// ================= QR CODE =================
// Encodes verification URL
$pdf->write2DBarcode(
    "https://yourgym.com/verify?id=".$data['cert_id'],
    'QRCODE,L',
    230, 115, 35, 35
);

// ================= GOLD SEAL =================
$pdf->SetFillColor(255, 215, 0);
$pdf->Ellipse(240, 60, 20, 20, 0, 0, 360, 'F');

$pdf->SetXY(230, 58);
$pdf->SetFont('helvetica', 'B', 8);
$pdf->MultiCell(20, 5, "VERIFIED", 0, 'C');

// ================= SIGNATURES =================
$pdf->SetY(150);

$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(90, 10, 'Trainer Signature', 'T', 0, 'C');
$pdf->Cell(90, 10, 'Authorized Signature', 'T', 1, 'C');

// ================= FOOTER =================
$pdf->SetY(-20);
$pdf->SetFont('helvetica', 'I', 9);
$pdf->Cell(0, 10, 'www.fitzonegym.com | contact@fitzonegym.com', 0, 0, 'C');

// ================= OUTPUT =================
// 'D' = Download | 'I' = Open in browser
$mode = isset($_GET['download']) ? 'D' : 'I';

$pdf->Output('gym_certificate.pdf', $mode);
?>