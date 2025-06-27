<?php
require('fpdf/fpdf.php');
include 'db.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Event Registrations Report', 0, 1, 'C');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$pdf->Cell(50, 10, 'Event', 1);
$pdf->Cell(50, 10, 'Name', 1);
$pdf->Cell(30, 10, 'Status', 1);
$pdf->Cell(30, 10, 'Amount', 1);
$pdf->Ln();

$query = "SELECT e.title, u.full_name, er.payment_status, er.amount_paid
          FROM event_registrations er
          JOIN users u ON er.user_id = u.id
          JOIN events e ON er.event_id = e.id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(50, 10, $row['title'], 1);
    $pdf->Cell(50, 10, $row['full_name'], 1);
    $pdf->Cell(30, 10, $row['payment_status'], 1);
    $pdf->Cell(30, 10,  ($row['amount_paid'] ?? 0), 1);
    $pdf->Ln();
}

$pdf->Output();
?>
