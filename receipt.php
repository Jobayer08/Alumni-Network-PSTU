<?php
include 'db.php';
session_start();

$ref = $_GET['ref'] ?? '';
if (!$ref) die("Invalid receipt.");

// Use correct field for user name — change 'full_name' if needed
$query = "SELECT er.*, e.title, u.full_name , p.amount, p.payment_date
          FROM event_registrations er
          JOIN users u ON er.user_id = u.id
          JOIN events e ON er.event_id = e.id
          JOIN payments p ON p.user_id = u.id AND p.event_id = e.id
          WHERE er.payment_reference = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $ref);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) die("Payment not found.");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
</head>
<body>
    <h2>Payment Receipt</h2>
    <div id="receipt">
        <p><strong>Name:</strong> <?= $data['full_name'] ?></p>
        <p><strong>Event:</strong> <?= $data['title'] ?></p>
        <p><strong>Amount Paid:</strong> ৳<?= $data['amount'] ?></p>
        <p><strong>Payment Method:</strong> <?= $data['payment_method'] ?></p>
        <p><strong>Payment Reference:</strong> <?= $ref ?></p>
        <p><strong>Date:</strong> <?= $data['payment_date'] ?></p>
    </div>

    <button onclick="downloadPDF()">Download Receipt (PDF)</button>

    <script>
    function downloadPDF() {
        const printWindow = window.open('', '_blank');
        const receiptContent = document.getElementById('receipt').innerHTML;
        printWindow.document.write(`
            <html>
            <head><title>Receipt</title></head>
            <body>
                <h2>Payment Receipt</h2>
                ${receiptContent}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
    </script>
</body>
</html>
