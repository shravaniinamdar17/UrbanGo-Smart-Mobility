<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db_connect.php";

if(!isset($_GET['station'])){
    header("Location:index.php");
    exit;
}

$stationId=(int)$_GET['station'];

$city=$_GET['city'];
$date=$_GET['date'];
$time=$_GET['time'];

$vehicle=$_GET['vehicle'];
$charger=$_GET['charger'];

/*
=========================================
Demo Station Data
Later Fetch From Database
=========================================
*/

$stations=[

1=>[
"name"=>"UrbanGo Charge Hub",
"image"=>"../../assets/images/ev/station1.jpg",
"charger"=>"DC Fast Charger",
"power"=>"60 kW",
"price"=>18,
"address"=>"Andheri East, Mumbai",
"rating"=>"4.9"
],

2=>[
"name"=>"Tata Power EZ Charge",
"image"=>"../../assets/images/ev/station2.jpg",
"charger"=>"Ultra Fast Charger",
"power"=>"120 kW",
"price"=>24,
"address"=>"Powai, Mumbai",
"rating"=>"4.8"
],

3=>[
"name"=>"ChargeZone",
"image"=>"../../assets/images/ev/station3.jpg",
"charger"=>"AC Charger",
"power"=>"22 kW",
"price"=>12,
"address"=>"Vashi, Navi Mumbai",
"rating"=>"4.7"
],

4=>[
"name"=>"Statiq Charging",
"image"=>"../../assets/images/ev/station4.jpg",
"charger"=>"Ultra Fast Charger",
"power"=>"150 kW",
"price"=>28,
"address"=>"Bandra West, Mumbai",
"rating"=>"4.9"
],

5=>[
"name"=>"Ather Grid",
"image"=>"../../assets/images/ev/station5.jpg",
"charger"=>"AC Charger",
"power"=>"15 kW",
"price"=>10,
"address"=>"Thane West",
"rating"=>"4.8"
]

];

$station=$stations[$stationId];

$estimatedUnits=25;

$estimatedAmount=$estimatedUnits*$station['price'];

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width,initial-scale=1.0">

<title>

Select Charging Slot

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

<section class="slot-page">

<div class="container">

<div class="section-title">

<span>

⚡ Slot Selection

</span>

<h2>

Choose Charging Time

</h2>

<p>

Reserve your preferred charging slot.

</p>

</div>

<div class="slot-card">

<div>

<div class="station-preview">

<img

src="<?php echo $station['image']; ?>"

style="width:100%;
height:100%;
object-fit:cover;
border-radius:20px;">

</div>

<div class="slot-grid">
    <?php

$slots=[

"08:00 AM",
"09:00 AM",
"10:00 AM",
"11:00 AM",
"12:00 PM",
"01:00 PM",
"02:00 PM",
"03:00 PM",
"04:00 PM",
"05:00 PM",
"06:00 PM",
"07:00 PM"

];

foreach($slots as $index=>$slot){

$class="slot";

if($index==2 || $index==8){

$class.=" booked";

}

?>

<label class="<?php echo $class; ?>">

<?php if($class=="slot"){ ?>

<input
type="radio"
name="charging_slot"
value="<?php echo $slot; ?>"
style="display:none;"
required>

<?php } ?>

<?php echo $slot; ?>

</label>

<?php

}

?>

</div>

</div>

<div class="slot-summary">

<div class="summary-box">

<i class="fa-solid fa-building"></i>

<div>

<h4>

Charging Station

</h4>

<p>

<?php echo htmlspecialchars($station['name']); ?>

</p>

</div>

</div>

<div class="summary-box">

<i class="fa-solid fa-location-dot"></i>

<div>

<h4>

Location

</h4>

<p>

<?php echo htmlspecialchars($station['address']); ?>

</p>

</div>

</div>

<div class="summary-box">

<i class="fa-solid fa-bolt"></i>

<div>

<h4>

Charger

</h4>

<p>

<?php

echo htmlspecialchars($station['charger']);

?>

•

<?php echo $station['power']; ?>

</p>

</div>

</div>

<div class="summary-box">

<i class="fa-solid fa-car"></i>

<div>

<h4>

Vehicle

</h4>

<p>

<?php echo htmlspecialchars($vehicle); ?>

</p>

</div>

</div>

<div class="summary-box">

<i class="fa-solid fa-gauge-high"></i>

<div>

<h4>

Estimated Energy

</h4>

<p>

<?php echo $estimatedUnits; ?>

kWh

</p>

</div>

</div>

<div class="summary-box">

<i class="fa-solid fa-indian-rupee-sign"></i>

<div>

<h4>

Estimated Cost

</h4>

<p>

₹<?php echo number_format($estimatedAmount,2); ?>

</p>

</div>

</div>

</div>

</div>

</div>

</section>

<section class="customer-form">

<div class="container">

<div class="customer-card">

<h2>

Customer Details

</h2>

<form

action="payment.php"

method="POST">

<input
type="hidden"
name="station_id"
value="<?php echo $stationId; ?>">

<input
type="hidden"
name="city"
value="<?php echo htmlspecialchars($city); ?>">

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
name="vehicle"
value="<?php echo htmlspecialchars($vehicle); ?>">

<input
type="hidden"
name="charger"
value="<?php echo htmlspecialchars($charger); ?>">

<input
type="hidden"
name="units"
value="<?php echo $estimatedUnits; ?>">

<input
type="hidden"
name="amount"
value="<?php echo $estimatedAmount; ?>">

<div class="customer-grid">

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

Vehicle Registration Number

</label>

<input
type="text"
name="vehicle_number"
required
placeholder="MH12AB1234">

</div>

<div class="input-box">

<label>

Battery Capacity (kWh)

</label>

<input
type="number"
name="battery_capacity"
placeholder="Example: 40">

</div>

<div class="input-box">

<label>

Current Battery Level (%)

</label>

<input
type="number"
name="battery_level"
min="0"
max="100"
placeholder="Example: 30">

</div>

</div>

<div class="bill-summary">

<h2>

Charging Summary

</h2>

<div class="bill-row">

<span>

Estimated Energy

</span>

<strong>

<?php echo $estimatedUnits; ?> kWh

</strong>

</div>

<div class="bill-row">

<span>

Rate

</span>

<strong>

₹<?php echo $station['price']; ?>/kWh

</strong>

</div>

<div class="bill-total">

<span>

Estimated Total

</span>

<span>

₹<?php echo number_format($estimatedAmount,2); ?>

</span>

</div>

<button

type="submit"

class="search-btn"

style="margin-top:30px;">

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

const slots=document.querySelectorAll(".slot");
const radios=document.querySelectorAll("input[name='charging_slot']");

slots.forEach(function(slot){

if(slot.classList.contains("booked")){
return;
}

slot.addEventListener("click",function(){

slots.forEach(function(item){

item.classList.remove("active");

});

slot.classList.add("active");

const radio=slot.querySelector("input[type='radio']");

if(radio){

radio.checked=true;

}

});

});

const form=document.querySelector("form");

form.addEventListener("submit",function(e){

const selected=document.querySelector("input[name='charging_slot']:checked");

if(!selected){

alert("Please select a charging slot.");

e.preventDefault();

return;

}

const mobile=document.querySelector("input[name='mobile']");
const vehicle=document.querySelector("input[name='vehicle_number']");
const battery=document.querySelector("input[name='battery_level']");

if(mobile.value.length!=10){

alert("Enter a valid 10-digit mobile number.");

mobile.focus();

e.preventDefault();

return;

}

if(vehicle.value.trim().length<6){

alert("Please enter a valid vehicle registration number.");

vehicle.focus();

e.preventDefault();

return;

}

if(
battery.value!="" &&
(
battery.value<0 ||
battery.value>100
)
){

alert("Battery level must be between 0 and 100%.");

battery.focus();

e.preventDefault();

return;

}

const button=document.querySelector(".search-btn");

button.disabled=true;

button.innerHTML='\
<i class="fa-solid fa-spinner fa-spin"></i>\
 Redirecting to Payment...';

});

});

</script>

<?php include "../../includes/layout/footer.php"; ?>

</body>

</html>