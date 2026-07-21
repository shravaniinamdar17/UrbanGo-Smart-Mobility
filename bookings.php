<?php
require_once "../config/config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin-login.php");
    exit;
}

$search = $_GET['search'] ?? "";

if($search!=""){

$sql="SELECT
b.*,
c1.city_name AS from_city,
c2.city_name AS to_city,
br.operator_name,
br.bus_name
FROM bookings b
JOIN bus_routes br ON b.route_id=br.id
JOIN cities c1 ON br.from_city=c1.id
JOIN cities c2 ON br.to_city=c2.id
WHERE b.booking_number LIKE ?
ORDER BY b.created_at DESC";

$stmt=$conn->prepare($sql);

$like="%".$search."%";

$stmt->bind_param("s",$like);

$stmt->execute();

$result=$stmt->get_result();

}else{

$result=$conn->query("
SELECT
b.*,
c1.city_name AS from_city,
c2.city_name AS to_city,
br.operator_name,
br.bus_name
FROM bookings b
JOIN bus_routes br ON b.route_id=br.id
JOIN cities c1 ON br.from_city=c1.id
JOIN cities c2 ON br.to_city=c2.id
ORDER BY b.created_at DESC
");

}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Manage Bookings</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="admin-content">

<h1>

Booking Management

</h1>

<form method="GET" class="search-form">

<input
type="text"
name="search"
placeholder="Search Booking Number..."
value="<?= htmlspecialchars($search) ?>">

<button>

Search

</button>

</form>

<table class="admin-table">

<tr>

<th>Booking No</th>

<th>Passenger</th>

<th>Route</th>

<th>Operator</th>

<th>Seats</th>

<th>Amount</th>

<th>Status</th>

<th>Date</th>

<th>Action</th>

</tr>
<?php while($booking = $result->fetch_assoc()){ ?>

<tr>

<td>

<strong>

<?= htmlspecialchars($booking['booking_number']) ?>

</strong>

</td>

<td>

<?= (int)$booking['passenger_count'] ?>

Passenger(s)

</td>

<td>

<?= htmlspecialchars($booking['from_city']) ?>

<br>

<i class="fa-solid fa-arrow-down"></i>

<br>

<?= htmlspecialchars($booking['to_city']) ?>

</td>

<td>

<?= htmlspecialchars($booking['operator_name']) ?>

<br>

<small>

<?= htmlspecialchars($booking['bus_name']) ?>

</small>

</td>

<td>

<?= htmlspecialchars($booking['seat_numbers']) ?>

</td>

<td>

₹<?= number_format($booking['total_amount'],2) ?>

</td>

<td>

<?php if($booking['booking_status']=="Confirmed"){ ?>

<span class="badge active">

Confirmed

</span>

<?php } elseif($booking['booking_status']=="Cancelled"){ ?>

<span class="badge inactive">

Cancelled

</span>

<?php } else { ?>

<span class="badge">

<?= htmlspecialchars($booking['booking_status']) ?>

</span>

<?php } ?>

</td>

<td>

<?= date("d M Y",strtotime($booking['created_at'])) ?>

<br>

<small>

<?= date("h:i A",strtotime($booking['created_at'])) ?>

</small>

</td>

<td>

<div class="action-buttons">

<a
href="../booking/ticket.php?id=<?= $booking['id'] ?>"
class="btn-edit">

<i class="fa-solid fa-ticket"></i>

Ticket

</a>

<?php if($booking['booking_status']=="Confirmed"){ ?>

<a
href="cancel-booking.php?id=<?= $booking['id'] ?>"
class="btn-delete"
onclick="return confirm('Cancel this booking?')">

<i class="fa-solid fa-ban"></i>

Cancel

</a>

<?php } ?>

</div>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>