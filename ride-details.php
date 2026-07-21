<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db_connect.php";

if(!isset($_GET['cab'])){
    header("Location:index.php");
    exit;
}

$cabId=(int)$_GET['cab'];

$pickup=$_GET['pickup'];
$drop=$_GET['drop'];
$date=$_GET['date'];
$time=$_GET['time'];
$distance=(float)$_GET['distance'];
$totalFare=(float)$_GET['fare'];
$passengers=(int)$_GET['passengers'];

/*
----------------------------------------
Demo Driver Data
Later fetch from cab_drivers table
----------------------------------------
*/

$cabs=[

1=>[
"driver"=>"Rahul Sharma",
"photo"=>"../../assets/images/drivers/driver1.jpg",
"vehicle"=>"Maruti WagonR",
"number"=>"MH12AB4587",
"type"=>"Mini",
"rating"=>"4.9"
],

2=>[
"driver"=>"Amit Singh",
"photo"=>"../../assets/images/drivers/driver2.jpg",
"vehicle"=>"Honda Amaze",
"number"=>"MH14CD7281",
"type"=>"Sedan",
"rating"=>"4.8"
],

3=>[
"driver"=>"Vikram Patil",
"photo"=>"../../assets/images/drivers/driver3.jpg",
"vehicle"=>"Toyota Innova",
"number"=>"MH43PQ1990",
"type"=>"SUV",
"rating"=>"4.9"
],

4=>[
"driver"=>"Rohan Mehta",
"photo"=>"../../assets/images/drivers/driver4.jpg",
"vehicle"=>"Hyundai Verna",
"number"=>"MH20XY1123",
"type"=>"Premium",
"rating"=>"5.0"
],

5=>[
"driver"=>"Arjun Kapoor",
"photo"=>"../../assets/images/drivers/driver5.jpg",
"vehicle"=>"BMW 5 Series",
"number"=>"MH01VIP001",
"type"=>"Luxury",
"rating"=>"5.0"
]

];

$cab=$cabs[$cabId];

$bookingFee=30;
$gst=round($totalFare*0.05);
$totalPayable=$totalFare+$bookingFee+$gst;
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>

Ride Details | UrbanGo

</title>

<link
rel="stylesheet"
href="../../assets/css/style.css">

<link
rel="stylesheet"
href="cab.css">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../../includes/layout/navbar.php"; ?>

<section class="ride-page">

<div class="container">

<div class="section-title">

<span>

🚖 Ride Details

</span>

<h2>

Review Your Ride

</h2>

<p>

Please verify your ride information before proceeding to payment.

</p>

</div>

<div class="ride-card">

<div>

<div class="driver-section">

<img
src="<?php echo $cab['photo']; ?>"
class="driver-photo"
alt="Driver">

<div class="driver-info">

<h2>

<?php echo htmlspecialchars($cab['driver']); ?>

</h2>

<h4>

⭐ <?php echo $cab['rating']; ?>

Driver Rating

</h4>

<p>

Professional Verified Driver

</p>

<div class="driver-features">

<span class="verified">

Verified Driver

</span>

<span class="online">

Available

</span>

</div>

</div>

</div>

<div class="ride-map">

🗺 Route Preview

<br><br>

<?php echo htmlspecialchars($pickup); ?>

<br>

↓

<br>

<?php echo htmlspecialchars($drop); ?>

</div>

</div>

<div class="route-summary">
    <div class="route-box">

<i class="fa-solid fa-location-dot"></i>

<div>

<h4>

Pickup Location

</h4>

<p>

<?php echo htmlspecialchars($pickup); ?>

</p>

</div>

</div>

<div class="route-box">

<i class="fa-solid fa-flag-checkered"></i>

<div>

<h4>

Drop Location

</h4>

<p>

<?php echo htmlspecialchars($drop); ?>

</p>

</div>

</div>

<div class="route-box">

<i class="fa-solid fa-calendar-days"></i>

<div>

<h4>

Journey Date & Time

</h4>

<p>

<?php

echo date("d M Y",strtotime($date));

?>

•

<?php echo date("h:i A",strtotime($time)); ?>

</p>

</div>

</div>

<div class="route-box">

<i class="fa-solid fa-road"></i>

<div>

<h4>

Trip Distance

</h4>

<p>

<?php echo $distance; ?> KM

</p>

</div>

</div>

<div class="route-box">

<i class="fa-solid fa-car-side"></i>

<div>

<h4>

Vehicle

</h4>

<p>

<?php

echo htmlspecialchars($cab['vehicle']);

?>

•

<?php

echo htmlspecialchars($cab['number']);

?>

</p>

</div>

</div>

<div class="route-box">

<i class="fa-solid fa-users"></i>

<div>

<h4>

Passengers

</h4>

<p>

<?php echo $passengers; ?>

Passenger(s)

</p>

</div>

</div>

</div>

</div>

<section class="passenger-form">

<div class="container">

<div class="passenger-card">

<h2>

Passenger Details

</h2>

<form
action="payment.php"
method="POST">

<input
type="hidden"
name="cab_id"
value="<?php echo $cabId; ?>">

<input
type="hidden"
name="pickup"
value="<?php echo htmlspecialchars($pickup); ?>">

<input
type="hidden"
name="drop"
value="<?php echo htmlspecialchars($drop); ?>">

<input
type="hidden"
name="date"
value="<?php echo htmlspecialchars($date); ?>">

<input
type="hidden"
name="time"
value="<?php echo htmlspecialchars($time); ?>">

<input
type="hidden"
name="distance"
value="<?php echo $distance; ?>">

<input
type="hidden"
name="fare"
value="<?php echo $totalPayable; ?>">

<input
type="hidden"
name="passengers"
value="<?php echo $passengers; ?>">

<div class="passenger-grid">

<div class="input-box">

<label>

Full Name

</label>

<input
type="text"
name="full_name"
required
placeholder="Enter Full Name">

</div>

<div class="input-box">

<label>

Mobile Number

</label>

<input
type="tel"
name="mobile"
maxlength="10"
required
placeholder="Enter Mobile Number">

</div>

<div class="input-box">

<label>

Email Address

</label>

<input
type="email"
name="email"
required
placeholder="Enter Email">

</div>

<div class="input-box">

<label>

Emergency Contact

</label>

<input
type="tel"
name="emergency_contact"
maxlength="10"
placeholder="Optional">

</div>

</div>

<div class="input-box"
style="margin-top:25px;">

<label>

Promo Code

</label>

<input
type="text"
name="promo"
placeholder="Enter Promo Code (Optional)">

</div>

<div class="input-box"
style="margin-top:25px;">

<label>

Special Ride Instructions

</label>

<textarea

name="instructions"

rows="5"

placeholder="Example: Call before arrival, luggage assistance, etc."

style="padding:18px;
border-radius:15px;
border:2px solid #ddd;
font-family:Poppins;
resize:none;">

</textarea>

</div>

<div class="booking-summary">

<h2>

Fare Summary

</h2>

<div class="summary-row">

<span>

Estimated Fare

</span>

<strong>

₹<?php echo number_format($totalFare); ?>

</strong>

</div>

<div class="summary-row">

<span>

Booking Fee

</span>

<strong>

₹<?php echo number_format($bookingFee); ?>

</strong>

</div>

<div class="summary-row">

<span>

GST (5%)

</span>

<strong>

₹<?php echo number_format($gst); ?>

</strong>

</div>

<div class="total-price">

<span>

Total Payable

</span>

<span>

₹<?php echo number_format($totalPayable); ?>

</span>

</div>

<button
type="submit"
class="search-btn">

<i class="fa-solid fa-credit-card"></i>

Continue To Payment

</button>

</div>

</form>

</div>

</div>

</section>

<!-- PART 3 STARTS BELOW -->
 <script>

document.addEventListener("DOMContentLoaded",function(){

const form=document.querySelector("form");

const mobile=document.querySelector("input[name='mobile']");
const emergency=document.querySelector("input[name='emergency_contact']");
const submitBtn=document.querySelector(".search-btn");

form.addEventListener("submit",function(e){

if(mobile.value.length!=10){

alert("Please enter a valid 10-digit mobile number.");

mobile.focus();

e.preventDefault();

return;

}

if(emergency.value!="" && emergency.value.length!=10){

alert("Emergency contact must contain 10 digits.");

emergency.focus();

e.preventDefault();

return;

}

submitBtn.disabled=true;

submitBtn.innerHTML='\
<i class="fa-solid fa-spinner fa-spin"></i>\
 Redirecting To Payment...';

});

});

/*=========================================
        Future Google Maps Hook
=========================================*/

// function loadRouteMap(){
// Google Maps API integration can be added here.
// }

</script>

<?php include "../../includes/layout/footer.php"; ?>

</body>

</html>