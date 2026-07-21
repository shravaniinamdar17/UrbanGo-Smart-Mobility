<?php
require_once "config/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "
SELECT *
FROM bookings
ORDER BY created_at DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Booking History</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet" href="assets/css/dashboard.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<section class="dashboard-page">

<div class="container">

<h1>Booking History</h1>

<table class="history-table">

<tr>

<th>Booking No</th>

<th>Seats</th>

<th>Amount</th>

<th>Status</th>

<th>Date</th>

<th>Ticket</th>

</tr>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td><?= htmlspecialchars($row['booking_number']) ?></td>

<td><?= htmlspecialchars($row['seat_numbers']) ?></td>

<td>₹<?= number_format($row['total_amount']) ?></td>

<td><?= htmlspecialchars($row['booking_status']) ?></td>

<td><?= $row['created_at'] ?></td>

<td>

<a href="booking/ticket.php?id=<?= $row['id'] ?>">

View

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</section>

</body>

</html>