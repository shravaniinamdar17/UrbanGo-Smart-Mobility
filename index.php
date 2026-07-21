<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../../login.php");
    exit;
}

require_once "../../config/db_connect.php";

$today=date("Y-m-d");

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Train Booking | UrbanGo</title>

<link rel="stylesheet" href="../../assets/css/style.css">

<link rel="stylesheet" href="train.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>


<body>


<?php include "../../includes/layout/navbar.php"; ?>


<section class="train-hero">


<div class="overlay"></div>


<div class="container">


<div class="hero-content">


<h1>

🚆 Premium Train Booking

</h1>


<p>

Book Express, Superfast, Rajdhani, Shatabdi and Vande Bharat trains across India.

</p>


</div>



<div class="search-card">


<form action="result.php" method="GET">



<div class="search-grid">



<div class="input-box">

<label>

From Station

</label>


<select name="from" required>


<option value="">

Select Departure Station

</option>


<option>Mumbai Central</option>

<option>Chhatrapati Shivaji Maharaj Terminus</option>

<option>Pune Junction</option>

<option>Delhi Junction</option>

<option>New Delhi</option>

<option>Bangalore City</option>

<option>Chennai Central</option>

<option>Hyderabad Deccan</option>

<option>Ahmedabad Junction</option>

<option>Nagpur Junction</option>


</select>

</div>



<div class="input-box">

<label>

To Station

</label>


<select name="to" required>


<option value="">

Select Destination Station

</option>


<option>Mumbai Central</option>

<option>Chhatrapati Shivaji Maharaj Terminus</option>

<option>Pune Junction</option>

<option>Delhi Junction</option>

<option>New Delhi</option>

<option>Bangalore City</option>

<option>Chennai Central</option>

<option>Hyderabad Deccan</option>

<option>Ahmedabad Junction</option>

<option>Nagpur Junction</option>


</select>

</div>



<div class="input-box">


<label>

Journey Date

</label>


<input

type="date"

name="date"

min="<?php echo $today; ?>"

required>


</div>



<div class="input-box">


<label>

Passengers

</label>


<select name="passengers">


<option value="1">

1 Passenger

</option>


<option value="2">

2 Passengers

</option>


<option value="3">

3 Passengers

</option>


<option value="4">

4 Passengers

</option>


<option value="5">

5 Passengers

</option>


</select>


</div>
<div class="input-box">

<label>

Train Type

</label>


<select name="train_type">


<option value="">

All Trains

</option>


<option>

Vande Bharat Express

</option>


<option>

Rajdhani Express

</option>


<option>

Shatabdi Express

</option>


<option>

Superfast Express

</option>


<option>

Express Train

</option>


<option>

Intercity Express

</option>


</select>

</div>




<div class="input-box">

<label>

Class

</label>


<select name="class">


<option value="">

All Classes

</option>


<option>

1A First AC

</option>


<option>

2A Second AC

</option>


<option>

3A Third AC

</option>


<option>

Sleeper

</option>


<option>

General

</option>


<option>

Chair Car

</option>


</select>

</div>




<div class="input-box">

<label>

Quota

</label>


<select name="quota">


<option>

General

</option>


<option>

Tatkal

</option>


<option>

Ladies

</option>


<option>

Senior Citizen

</option>


<option>

Premium Tatkal

</option>


</select>

</div>




<div class="input-box">

<label>

Departure Time

</label>


<select name="time">


<option>

Any Time

</option>


<option>

Morning (6 AM - 12 PM)

</option>


<option>

Afternoon (12 PM - 5 PM)

</option>


<option>

Evening (5 PM - 9 PM)

</option>


<option>

Night (9 PM - 6 AM)

</option>


</select>

</div>



<div class="input-box">

<label>

Train Operator

</label>


<select name="operator">


<option>

Indian Railways

</option>


<option>

IRCTC Premium

</option>


<option>

Vande Bharat Network

</option>


</select>

</div>


</div>
<!-- TRAIN FEATURES -->

<div class="facility-tags">

<span>🚆 Express</span>

<span>⚡ Vande Bharat</span>

<span>❄ AC Coach</span>

<span>💺 Reserved Seats</span>

<span>🍽 Food Service</span>

<span>📶 WiFi</span>

<span>🔌 Charging Point</span>

<span>📍 Live Tracking</span>

<span>🛡 CCTV Security</span>

<span>♿ Accessible</span>

</div>



<button type="submit" class="search-btn">

<i class="fa-solid fa-train"></i>

Search Trains

</button>


</form>

</div>

</div>

</section>



<!-- POPULAR TRAIN ROUTES -->

<section class="popular-routes">

<div class="container">


<h2>

🔥 Popular Train Routes

</h2>



<div class="routes-grid">


<div class="route-card">

<h3>

Mumbai → Delhi

</h3>

<p>

Rajdhani Express Available

</p>

</div>



<div class="route-card">

<h3>

Mumbai → Pune

</h3>

<p>

Intercity Express Available

</p>

</div>



<div class="route-card">

<h3>

Delhi → Jaipur

</h3>

<p>

Superfast Trains Available

</p>

</div>



<div class="route-card">

<h3>

Bangalore → Chennai

</h3>

<p>

Shatabdi Express Available

</p>

</div>



</div>


</div>

</section>



<?php include "../../includes/layout/footer.php"; ?>


</body>

</html>