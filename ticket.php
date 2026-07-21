<?php
require_once "../config/config.php";

$booking_id = (int)($_GET['id'] ?? 0);

$sql = "
SELECT
b.*,
br.operator_name,
br.bus_name,
br.departure_time,
br.arrival_time,
c1.city_name AS from_city,
c2.city_name AS to_city
FROM bookings b
JOIN bus_routes br ON b.route_id=br.id
JOIN cities c1 ON br.from_city=c1.id
JOIN cities c2 ON br.to_city=c2.id
WHERE b.id=?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$booking_id);
$stmt->execute();

$booking = $stmt->get_result()->fetch_assoc();

if(!$booking){
    die("Booking Not Found");
}

$passengers = [];

$p = $conn->prepare("
SELECT *
FROM booking_passengers
WHERE booking_id=?
");

$p->bind_param("i",$booking_id);
$p->execute();

$result = $p->get_result();

while($row=$result->fetch_assoc()){
    $passengers[]=$row;
}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>UrbanGo Ticket</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/layout/navbar.php"; ?>

<section class="ticket-page">

<div class="container">

<div class="ticket-card">

<div class="ticket-header">

<h1>UrbanGo e-Ticket</h1>

<div>

Booking No

<br>

<strong>

<?= htmlspecialchars($booking['booking_number']) ?>

</strong>

</div>

</div>

<hr>

<div class="ticket-grid">

<div>

<h3>Operator</h3>

<p><?= htmlspecialchars($booking['operator_name']) ?></p>

</div>

<div>

<h3>Bus</h3>

<p><?= htmlspecialchars($booking['bus_name']) ?></p>

</div>

<div>

<h3>From</h3>

<p><?= htmlspecialchars($booking['from_city']) ?></p>

</div>

<div>

<h3>To</h3>

<p><?= htmlspecialchars($booking['to_city']) ?></p>

</div>

<div>

<h3>Departure</h3>

<p><?= date("h:i A",strtotime($booking['departure_time'])) ?></p>

</div>

<div>

<h3>Arrival</h3>

<p><?= date("h:i A",strtotime($booking['arrival_time'])) ?></p>

</div>

<div>

<h3>Seats</h3>

<p><?= htmlspecialchars($booking['seat_numbers']) ?></p>

</div>

<div>

<h3>Total Paid</h3>

<p>₹<?= number_format($booking['total_amount']) ?></p>

</div>

</div>

<hr>

<h2>Passengers</h2>

<table class="ticket-table">

<tr>

<th>Name</th>

<th>Age</th>

<th>Gender</th>

</tr>

<?php foreach($passengers as $person){ ?>

<tr>

<td><?= htmlspecialchars($person['passenger_name']) ?></td>

<td><?= $person['age'] ?></td>

<td><?= htmlspecialchars($person['gender']) ?></td>

</tr>

<?php } ?>

</table>

<div class="ticket-footer">

<div class="qr-placeholder">

QR CODE

</div>

<div>

<p>

Payment Status

</p>

<h2 style="color:#0ecb81">

<?= htmlspecialchars($booking['payment_status']) ?>

</h2>

</div>

</div>

<div class="ticket-buttons">

<button onclick="window.print()">

Print Ticket

</button>

<a href="../index.php">

Home

</a>

</div>

</div>

</div>

</section>

</body>

</html>