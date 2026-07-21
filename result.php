<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db_connect.php";

$from=$_GET['from'] ?? "";
$to=$_GET['to'] ?? "";
$date=$_GET['date'] ?? "";
$passengers=$_GET['passengers'] ?? 1;

$sql="SELECT *
FROM metro_routes
WHERE from_station=?
AND to_station=?
AND is_active=1
ORDER BY departure_time";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"ss",
$from,
$to
);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>Available Metro | UrbanGo</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

<link rel="stylesheet"
href="metro.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../../includes/layout/navbar.php"; ?>

<section class="results-page">

<div class="container">

<div class="section-title">

<span>

🚇 Available Metro

</span>

<h2>

<?php echo htmlspecialchars($from); ?>

→

<?php echo htmlspecialchars($to); ?>

</h2>

<p>

Journey Date :

<?php echo htmlspecialchars($date); ?>

|

Passengers :

<?php echo (int)$passengers; ?>

</p>

</div>
<?php

if(mysqli_num_rows($result)>0){

while($metro=mysqli_fetch_assoc($result)){

?>

<div class="metro-card">

<div class="metro-left">

<h2>

<?php echo htmlspecialchars($metro['metro_line']); ?>

</h2>

<h3>

<?php echo htmlspecialchars($metro['metro_name']); ?>

</h3>

<p>

Air Conditioned Rapid Metro Service

</p>

<div class="metro-badges">

<span>

🚉

<?php echo $metro['total_stations']; ?>

Stations

</span>

<span class="available">

<?php echo $metro['available_seats']; ?>

Seats

</span>

<span class="express">

⚡ Every 5 Minutes

</span>

</div>

</div>

<div class="metro-center">

<div class="station-time">

<?php echo date("h:i A",strtotime($metro['departure_time'])); ?>

</div>

<div class="station-name">

<?php echo htmlspecialchars($metro['from_station']); ?>

</div>

<div class="metro-line"></div>

<div class="metro-duration">

<?php echo htmlspecialchars($metro['journey_duration']); ?>

</div>

<div class="metro-line"></div>

<div class="station-time">

<?php echo date("h:i A",strtotime($metro['arrival_time'])); ?>

</div>

<div class="station-name">

<?php echo htmlspecialchars($metro['to_station']); ?>

</div>

</div>

<div class="metro-right">

<h2>

₹<?php echo number_format($metro['fare']); ?>

</h2>

<p>

⭐ 4.9

(15,000+ Ratings)

</p>

<a

href="seat-selection.php?id=<?php echo $metro['id']; ?>&passengers=<?php echo (int)$passengers; ?>&date=<?php echo urlencode($date); ?>"

class="primary-btn">

Select Seats

</a>

</div>

</div>

<?php

}

}else{

?>

<div style="background:#fff;
padding:60px;
border-radius:25px;
text-align:center;
box-shadow:0 15px 35px rgba(0,0,0,.08);">

<i

class="fa-solid fa-train-subway"

style="font-size:70px;
color:#009688;
margin-bottom:20px;">

</i>

<h2>

No Metro Available

</h2>

<p>

No metro services are available for your selected route.

Please try another station or journey date.

</p>

<br>

<a

href="index.php"

class="primary-btn">

Search Again

</a>

</div>

<?php

}

?>

</div>

</section>

<!-- PART 3 STARTS BELOW -->
 <section class="metro-features">

<div class="container">

<div class="section-title">

<span>

Why Choose UrbanGo Metro

</span>

<h2>

Travel Smarter Every Day

</h2>

<p>

Fast, secure and cashless metro booking with premium features.

</p>

</div>

<div class="feature-grid">

<div class="feature-card">

<i class="fa-solid fa-qrcode"></i>

<h3>

Instant QR Ticket

</h3>

<p>

Book your metro ticket in seconds and receive an instant QR ticket for hassle-free entry.

</p>

</div>

<div class="feature-card">

<i class="fa-solid fa-location-dot"></i>

<h3>

Live Metro Tracking

</h3>

<p>

Track arriving trains, station locations and estimated arrival time in real time.

</p>

</div>

<div class="feature-card">

<i class="fa-solid fa-credit-card"></i>

<h3>

Secure Payments

</h3>

<p>

Pay using UPI, Credit Card, Debit Card, Wallet or Net Banking with encrypted checkout.

</p>

</div>

<div class="feature-card">

<i class="fa-solid fa-mobile-screen-button"></i>

<h3>

Digital Ticket

</h3>

<p>

Paperless journey with printable and downloadable metro tickets.

</p>

</div>

<div class="feature-card">

<i class="fa-solid fa-bolt"></i>

<h3>

Fast Booking

</h3>

<p>

Search, book and confirm your metro ticket within a few seconds.

</p>

</div>

<div class="feature-card">

<i class="fa-solid fa-headset"></i>

<h3>

24×7 Support

</h3>

<p>

Our UrbanGo support team is available anytime to assist your journey.

</p>

</div>

</div>

</div>

</section>

<?php include "../../includes/layout/footer.php"; ?>

</body>

</html>