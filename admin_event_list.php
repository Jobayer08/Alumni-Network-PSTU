<?php
include 'db.php';
session_start();

// Assume admin is logged in
$query = "SELECT e.title, u.name, er.payment_status, er.amount_paid
          FROM event_registrations er
          JOIN users u ON er.user_id = u.id
          JOIN events e ON er.event_id = e.id
          ORDER BY e.title";
$result = mysqli_query($conn, $query);
?>

<h2>All Event Registrations</h2>
<table border="1">
    <tr>
        <th>Event</th><th>Name</th><th>Status</th><th>Amount</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['payment_status'] ?></td>
            <td>৳<?= $row['amount_paid'] ?? 0 ?></td>
        </tr>
    <?php } ?>
</table>

<a href="download_pdf.php" target="_blank">Download PDF</a>
