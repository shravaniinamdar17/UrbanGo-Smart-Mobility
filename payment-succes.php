<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db_connect.php";

if($_SERVER["REQUEST_METHOD"]!="POST"){
    header("Location:index.php");
    exit;
}

$userId=$_SESSION['user_id'];

$cabId=(int)$_POST['cab_id'];

$pickup=trim($_POST['pickup']);
$drop=trim($_POST['drop']);

$journeyDate=$_POST['journey_date'];
$journeyTime=$_POST['journey_time'];

$distance=(float)$_POST['distance'];

$totalAmount=(float)$_POST['grand_total'];

$passengers=(int)$_POST['passengers'];

$fullName=trim($_POST['full_name']);
$mobile=trim($_POST['mobile']);
$email=trim($_POST['email']);

$emergencyContact=trim($_POST['emergency_contact']);

$promo=trim($_POST['promo']);
$instructions=trim($_POST['instructions']);

$paymentMethod=$_POST['payment_method'];

$payerName=trim($_POST['payer_name']);

$paymentId=trim($_POST['payment_id']);

/*=========================================
    Generate Booking Information
=========================================*/

$bookingReference="UGCAB".date("Ymd").rand(1000,9999);

$rideNumber="CAB".rand(100000,999999);

$transactionId="TXN".date("YmdHis").rand(100,999);

$paymentStatus="Paid";

$bookingStatus="Confirmed";

/*=========================================
        Save Booking
=========================================*/

$sql="INSERT INTO bookings(

user_id,
service_type,
service_id,
booking_reference,
travel_date,
seat_numbers,
passenger_name,
passenger_mobile,
passenger_email,
total_amount,
booking_status

)

VALUES(

?,?,?,?,?,?,?,?,?,?,?

)";

$stmt=mysqli_prepare($conn,$sql);

$seat="N/A";

$serviceType="Cab";

mysqli_stmt_bind_param(

$stmt,

"isissssssds",

$userId,
$serviceType,
$cabId,
$bookingReference,
$journeyDate,
$seat,
$fullName,
$mobile,
$email,
$totalAmount,
$bookingStatus

);

mysqli_stmt_execute($stmt);

$bookingId=mysqli_insert_id($conn);

/*=========================================
        Save Payment
=========================================*/

$sql="INSERT INTO payments(

booking_id,
payment_method,
transaction_id,
amount,
payment_status

)

VALUES(

?,?,?,?,?

)";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(

$stmt,

"issds",

$bookingId,
$paymentMethod,
$transactionId,
$totalAmount,
$paymentStatus

);

mysqli_stmt_execute($stmt);

/*=========================================
Demo Cab Data
Later Fetch From Database
=========================================*/

$cabs=[

1=>[
"driver"=>"Rahul Sharma",
"vehicle"=>"Maruti WagonR",
"number"=>"MH12AB4587",
"type"=>"Mini"
],

2=>[
"driver"=>"Amit Singh",
"vehicle"=>"Honda Amaze",
"number"=>"MH14CD7281",
"type"=>"Sedan"
],

3=>[
"driver"=>"Vikram Patil",
"vehicle"=>"Toyota Innova",
"number"=>"MH43PQ1990",
"type"=>"SUV"
],

4=>[
"driver"=>"Rohan Mehta",
"vehicle"=>"Hyundai Verna",
"number"=>"MH20XY1123",
"type"=>"Premium"
],

5=>[
"driver"=>"Arjun Kapoor",
"vehicle"=>"BMW 5 Series",
"number"=>"MH01VIP001",
"type"=>"Luxury"
]

];

$cab=$cabs[$cabId];

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>

Cab Booking Successful

</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

<link rel="stylesheet"
href="cab.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<link rel="stylesheet"
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

🎉 Ride Confirmed

</h2>

<p>

Thank you for choosing UrbanGo Cab.

</p>

</div>

<span>

SUCCESS

</span>

</div>

<div class="ticket-details">
    <div class="ticket-box">

<h4>Booking Reference</h4>

<p>

<?php echo $bookingReference; ?>

</p>

</div>

<div class="ticket-box">

<h4>Ride Number</h4>

<p>

<?php echo $rideNumber; ?>

</p>

</div>

<div class="ticket-box">

<h4>Transaction ID</h4>

<p>

<?php echo $transactionId; ?>

</p>

</div>

<div class="ticket-box">

<h4>Passenger Name</h4>

<p>

<?php echo htmlspecialchars($fullName); ?>

</p>

</div>

<div class="ticket-box">

<h4>Mobile Number</h4>

<p>

<?php echo htmlspecialchars($mobile); ?>

</p>

</div>

<div class="ticket-box">

<h4>Email Address</h4>

<p>

<?php echo htmlspecialchars($email); ?>

</p>

</div>

<div class="ticket-box">

<h4>Driver Name</h4>

<p>

<?php echo htmlspecialchars($cab['driver']); ?>

</p>

</div>

<div class="ticket-box">

<h4>Vehicle</h4>

<p>

<?php

echo htmlspecialchars($cab['vehicle']);

?>

</p>

</div>

<div class="ticket-box">

<h4>Vehicle Number</h4>

<p>

<?php

echo htmlspecialchars($cab['number']);

?>

</p>

</div>

<div class="ticket-box">

<h4>Cab Category</h4>

<p>

<?php

echo htmlspecialchars($cab['type']);

?>

</p>

</div>

<div class="ticket-box">

<h4>Pickup Location</h4>

<p>

<?php echo htmlspecialchars($pickup); ?>

</p>

</div>

<div class="ticket-box">

<h4>Destination</h4>

<p>

<?php echo htmlspecialchars($drop); ?>

</p>

</div>

<div class="ticket-box">

<h4>Journey Date</h4>

<p>

<?php

echo date("d M Y",strtotime($journeyDate));

?>

</p>

</div>

<div class="ticket-box">

<h4>Pickup Time</h4>

<p>

<?php

echo date("h:i A",strtotime($journeyTime));

?>

</p>

</div>

<div class="ticket-box">

<h4>Trip Distance</h4>

<p>

<?php echo number_format($distance,1); ?> KM

</p>

</div>

<div class="ticket-box">

<h4>Passengers</h4>

<p>

<?php echo $passengers; ?>

</p>

</div>

<div class="ticket-box">

<h4>Payment Method</h4>

<p>

<?php echo htmlspecialchars($paymentMethod); ?>

</p>

</div>

<div class="ticket-box">

<h4>Payment Status</h4>

<p style="color:#28a745;font-weight:700;">

<?php echo $paymentStatus; ?>

</p>

</div>

<div class="ticket-box">

<h4>Total Paid</h4>

<p>

₹<?php echo number_format($totalAmount,2); ?>

</p>

</div>

</div>

<hr style="margin:40px 0;">

<div class="qr-section">

<img

src="../../assets/images/qr-demo.png"

alt="Ride QR Code">

<p>

Show this QR Code to your driver before starting the ride.

</p>

</div>

<div class="receipt-actions">

<a

href="receipt.php?id=<?php echo $bookingId; ?>">

<i class="fa-solid fa-file-lines"></i>

View Receipt

</a>

<button

onclick="window.print()">

<i class="fa-solid fa-print"></i>

Print Receipt

</button>

<a

href="../../dashboard.php">

<i class="fa-solid fa-house"></i>

Dashboard

</a>

</div>

</div>

</div>

</section>

<?php include "../../includes/layout/footer.php"; ?>

</body>

</html>