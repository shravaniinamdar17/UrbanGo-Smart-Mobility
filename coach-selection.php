<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Coach Selection | UrbanGo</title>

<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="train.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/layout/navbar.php"; ?>

<section class="seat-page">

<div class="container">

<div class="seat-header">

<div>

<span class="booking-tag">

🚆 Coach Selection

</span>

<h1>

Choose Your Coach & Berth

</h1>

<h3>

22223 Vande Bharat Express

</h3>

<p>

Mumbai CSMT → Pune Junction

</p>

</div>

<div class="fare-box">

<h2>

₹1250

</h2>

<p>per passenger</p>

</div>

</div>

<div class="seat-wrapper">

<div class="bus-layout">

<h2>Select Coach</h2>

<br>

<div class="booking-grid">

<button class="tab active">C1</button>

<button class="tab">C2</button>

<button class="tab">C3</button>

<button class="tab">C4</button>

<button class="tab">C5</button>

<button class="tab">Executive</button>

</div>

<br><br>

<h2>Select Berth</h2>

<div class="seat-grid">
    <?php

$booked=[2,6,8,10,17,21,24,31,36];

for($i=1;$i<=40;$i++){

if(($i-1)%4==0){

echo '<div class="seat-row">';

}

$class="seat";

if(in_array($i,$booked)){

$class.=" booked";

}

echo '

<label class="'.$class.'">

<input type="checkbox">

<span>'.$i.'</span>

</label>

';

if($i%2==0){

echo '<div class="aisle"></div>';

}

if($i%4==0){

echo '</div>';

}

}

?>

</div>
<div class="legend">

<div>

<div class="available-box"></div>

Available

</div>

<div>

<div class="selected-box"></div>

Selected

</div>

<div>

<div class="booked-box"></div>

Booked

</div>

</div>

</div>
<div class="booking-summary">

<h2>

Journey Summary

</h2>

<div class="summary-card">

<p>

Train

<span>

Vande Bharat

</span>

</p>

<p>

Coach

<span>

C1

</span>

</p>

<p>

Selected Berths

<span id="seatCount">

0

</span>

</p>

<hr>

<p>

Total Fare

<strong id="totalFare">

₹0

</strong>

</p>

<a href="passenger.php">

<button class="continue-btn">

Continue

</button>

</a>

</div>

</div>

</div>

</div>

</section>

<script>

const seats=document.querySelectorAll('.seat input');

const seatCount=document.getElementById('seatCount');

const totalFare=document.getElementById('totalFare');

const fare=1250;

function updateFare(){

let total=0;

seats.forEach(seat=>{

if(seat.checked) total++;

});

seatCount.innerHTML=total;

totalFare.innerHTML="₹"+(fare*total);

}

seats.forEach(seat=>{

seat.addEventListener("change",updateFare);

});

</script>

<?php include "../includes/layout/footer.php"; ?>

</body>

</html>