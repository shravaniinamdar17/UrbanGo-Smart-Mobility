<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Bus Booking | UrbanGo</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "includes/layout/navbar.php"; ?>

<section class="booking-page">

<div class="container">

<div class="booking-title">

<h1>🚌 Bus Booking</h1>

<p>Search buses across India</p>

</div>

<form action="bus-results.php" method="GET">

<div class="booking-grid">

<div class="input-box">

<label>From</label>

<select name="from" required>

<option value="">Select Departure City</option>

<option>Mumbai</option>

<option>Pune</option>

<option>Nashik</option>

<option>Nagpur</option>

<option>Delhi</option>

<option>Bangalore</option>

<option>Hyderabad</option>

<option>Chennai</option>

</select>

</div>

<div class="input-box">

<label>To</label>

<select name="to" required>

<option value="">Select Destination</option>

<option>Mumbai</option>

<option>Pune</option>

<option>Nashik</option>

<option>Nagpur</option>

<option>Delhi</option>

<option>Bangalore</option>

<option>Hyderabad</option>

<option>Chennai</option>

</select>

</div>

<div class="input-box">

<label>Journey Date</label>

<input type="date" name="date" required>

</div>

<div class="input-box">

<label>Passengers</label>

<select name="passengers">

<option>1</option>

<option>2</option>

<option>3</option>

<option>4</option>

<option>5</option>

<option>6</option>

</select>

</div>

<div class="input-box">

<label>Bus Type</label>

<select name="bus_type">

<option>Any</option>

<option>AC Sleeper</option>

<option>Non AC Sleeper</option>

<option>AC Seater</option>

<option>Non AC Seater</option>

<option>Volvo AC</option>

<option>Luxury Coach</option>

<option>Electric Bus</option>

</select>

</div>

<div class="input-box">

<label>Operator</label>

<select name="operator">

<option>All Operators</option>

<option>VRL Travels</option>

<option>SRS Travels</option>

<option>Neeta Travels</option>

<option>Orange Travels</option>

<option>Sharma Travels</option>

</select>

</div>

<div class="input-box">

<label>Boarding Point</label>

<select>

<option>Any Boarding Point</option>

<option>Mumbai Central</option>

<option>Dadar</option>

<option>Borivali</option>

<option>Pune Station</option>

</select>

</div>

<div class="input-box">

<label>Dropping Point</label>

<select>

<option>Any Dropping Point</option>

<option>Mumbai Central</option>

<option>Dadar</option>

<option>Borivali</option>

<option>Pune Station</option>

</select>

</div>

</div>

<div class="filter-box">

<h3>Bus Facilities</h3>

<label><input type="checkbox"> AC</label>

<label><input type="checkbox"> Non AC</label>

<label><input type="checkbox"> Sleeper</label>

<label><input type="checkbox"> Seater</label>

<label><input type="checkbox"> WiFi</label>

<label><input type="checkbox"> Charging Port</label>

<label><input type="checkbox"> Live Tracking</label>

<label><input type="checkbox"> Female Friendly</label>

<label><input type="checkbox"> CCTV</label>

<label><input type="checkbox"> Water Bottle</label>

</div>

<button class="search-btn">

<i class="fas fa-search"></i>

Search Buses

</button>

</form>

</div>

</section>

<?php include "includes/layout/footer.php"; ?>

</body>

</html>