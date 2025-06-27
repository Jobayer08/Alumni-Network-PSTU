<?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$conn = new mysqli("localhost", "root", "", "alumni_db");

if (!isset($_GET['registration_id'])) {
    die("Missing registration ID.");
}

$registration_id = (int)$_GET['registration_id'];

// Fetch event and user info
$sql = "SELECT e.title, e.event_date, e.location, u.full_name, u.email, r.payment_reference, r.amount_paid, r.created_at 
        FROM event_registrations r
        JOIN events e ON r.event_id = e.id
        JOIN users u ON r.user_id = u.id
        WHERE r.id = $registration_id";
        
$result = $conn->query($sql);
if ($result->num_rows === 0) {
    die("Receipt not found.");
}

$row = $result->fetch_assoc();

// Prepare HTML
$html = '
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    .header { text-align: center; margin-bottom: 20px; }
    .receipt-box { border: 1px solid #333; padding: 20px; }
    h2 { margin-bottom: 0; }
    .section { margin-top: 10px; }
</style>
<div class="receipt-box">
    <div class="header">
        <h2>🎓 Alumni Event Payment Receipt</h2>
    </div>
    <div class="section">
        <strong>Full Name:</strong> ' . $row['full_name'] . '<br>
        <strong>Email:</strong> ' . $row['email'] . '<br>
        <strong>Event:</strong> ' . $row['title'] . '<br>
        <strong>Date:</strong> ' . $row['event_date'] . ' @ ' . $row['location'] . '<br>
        <strong>Payment Ref:</strong> ' . $row['payment_reference'] . '<br>
        <strong>Amount Paid:</strong> Tk ' . $row['amount_paid'] . '<br>
        <strong>Payment Date:</strong> ' . $row['created_at'] . '
    </div>
    <p style="margin-top: 20px;">Thank you for your participation!</p>
</div>
';

// Generate PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4');
$dompdf->render();
$dompdf->stream("receipt_$registration_id.pdf", ["Attachment" => false]);
