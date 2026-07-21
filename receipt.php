<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db_connect.php";

if(!isset($_GET['id'])){
    header("Location: ../../dashboard.php");
    exit;
}

$bookingId=(int)$_GET['id'];

$sql="SELECT
b.*,
p.payment_method,
p.transaction_id,
p.payment_status

FROM bookings b

LEFT JOIN payments p
ON b.booking_id=p.booking_id

WHERE
b.booking_id=?

LIMIT 1";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$bookingId);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($result)==0){

die("Booking not found.");

}

$booking=mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width,initial-scale=1.0">

<title>

UrbanGo EV Charging Receipt

</title>

<link
rel="stylesheet"
href="../../assets/css/style.css">

<link
rel="stylesheet"
href="ev.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../../includes/layout/navbar.php"; ?>

<section class="receipt-page">

<div class="container">

<div class="receipt">

<div class="receipt-header">

<div>

<h2>

⚡ UrbanGo EV Receipt

</h2>

<p>

Official Charging Booking Receipt

</p>

</div>

<span>

<?php echo strtoupper($booking['booking_status']); ?>

</span>

</div>

<div class="bill-summary">

<h2>

Booking Information

</h2>

<div class="bill-row">

<span>

Booking Reference

</span>

<strong>

<?php echo htmlspecialchars($booking['booking_reference']); ?>

</strong>

</div>

<div class="bill-row">

<span>

Booking Date

</span>

<strong>

<?php echo htmlspecialchars($booking['travel_date']); ?>

</strong>

</div>

<div class="bill-row">

<span>

Charging Slot

</span>

<strong>

<?php echo htmlspecialchars($booking['seat_numbers']); ?>

</strong>

</div>

<div class="bill-row">

<span>

Booking Status

</span>

<strong style="color:#2E7D32;">

<?php echo htmlspecialchars($booking['booking_status']); ?>

</strong>

</div>

</div>

<div class="bill-summary">

<h2>

Customer Information

</h2>

<div class="bill-row">

<span>

Passenger Name

</span>

<strong>

<?php echo htmlspecialchars($booking['passenger_name']); ?>

</strong>

</div>

<div class="bill-row">

<span>

Mobile Number

</span>

<strong>

<?php echo htmlspecialchars($booking['passenger_mobile']); ?>

</strong>

</div>

<div class="bill-row">

<span>

Email

</span>

<strong>

<?php echo htmlspecialchars($booking['passenger_email']); ?>

</strong>

</div>
</div>

<div class="bill-summary">

<h2>

Payment Information

</h2>

<div class="bill-row">

<span>

Payment Method

</span>

<strong>

<?php echo htmlspecialchars($booking['payment_method']); ?>

</strong>

</div>

<div class="bill-row">

<span>

Transaction ID

</span>

<strong>

<?php echo htmlspecialchars($booking['transaction_id']); ?>

</strong>

</div>

<div class="bill-row">

<span>

Payment Status

</span>

<strong style="color:#2E7D32;">

<?php echo htmlspecialchars($booking['payment_status']); ?>

</strong>

</div>

<div class="bill-row">

<span>

Service Type

</span>

<strong>

EV Charging

</strong>

</div>

<div class="bill-total">

<span>

Total Paid

</span>

<span>

₹<?php echo number_format($booking['total_amount'],2); ?>

</span>

</div>

</div>

<div class="qr-box">

<img

src="../../assets/images/qr-demo.png"

alt="UrbanGo Receipt QR">

<p>

Present this QR code at the charging station for booking verification.

</p>

</div>

<div class="receipt-actions">

<button onclick="window.print();">

<i class="fa-solid fa-print"></i>

Print Receipt

</button>

<a
href="../../dashboard.php">

<i class="fa-solid fa-house"></i>

Back to Dashboard

</a>

<a
href="../../my-bookings.php">

<i class="fa-solid fa-ticket"></i>

My Bookings

</a>

</div>

</div>

</div>

</section>

<?php include "../../includes/layout/footer.php"; ?>

</body>

</html>