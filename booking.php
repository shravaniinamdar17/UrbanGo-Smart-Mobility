<?php
session_start();
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Metro Booking | UrbanGo</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet" href="metro.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/layout/navbar.php"; ?>

<section class="booking-section">

<div class="container">

<div class="section-title">

<span>🚇 Metro Ticket Booking</span>

<h2>Travel Faster with UrbanGo Metro</h2>

<p>Book QR Metro Tickets and Smart Card Recharge in seconds.</p>

</div>

<form action="result.php" method="GET">

<div class="booking-box">

<div class="booking-grid">

<div class="input-group">

<label>From Station</label>

<select name="from">

<option>Andheri</option>
<option>Ghatkopar</option>
<option>Dahisar</option>
<option>Versova</option>
<option>CSMT</option>
<option>Airport Road</option>

</select>

</div>

<div class="input-group">

<label>To Station</label>

<select name="to">

<option>Ghatkopar</option>
<option>Andheri</option>
<option>Dahisar</option>
<option>Airport Road</option>
<option>CSMT</option>

</select>

</div>

<div class="input-group">

<label>Journey Date</label>

<input type="date" required>

</div>

<div class="input-group">

<label>Passengers</label>

<select>

<option>1</option>

<option>2</option>

<option>3</option>

<option>4</option>

<option>5</option>

</select>

</div>

<div class="input-group">

<label>Ticket Type</label>

<select>

<option>QR Ticket</option>

<option>Smart Card</option>

<option>Tourist Pass</option>

<option>Student Pass</option>

</select>

</div>

<div class="input-group">

<label>Metro Line</label>

<select>

<option>Blue Line</option>

<option>Yellow Line</option>

<option>Green Line</option>

<option>Red Line</option>

<option>Aqua Line</option>

<option>Purple Line</option>

</select>

</div>

</div>

<br>

<button class="search-btn">

Search Metro

</button>

</div>

</form>

</div>

</section>

<?php include "../includes/layout/footer.php"; ?>

</body>

</html>