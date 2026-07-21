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

$train_id=(int)$_POST['train_id'];

$selectedSeats=trim($_POST['selected_seats']);

$totalFare=(float)$_POST['total_fare'];

$seatArray=array_filter(explode(",",$selectedSeats));

$sql="SELECT * FROM train_routes WHERE id=?";

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$train_id);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

$train=mysqli_fetch_assoc($result);

if(!$train){

die("Train not found.");

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>Passenger Details | UrbanGo</title>

<link rel="stylesheet"
href="../../assets/css/style.css">

<link rel="stylesheet"
href="train.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../../includes/layout/navbar.php"; ?>

<section class="passenger-form">

<div class="container">

<div class="section-title">

<span>🚆 Passenger Details</span>

<h2>

<?php echo htmlspecialchars($train['train_number']); ?>

-

<?php echo htmlspecialchars($train['train_name']); ?>

</h2>

<p>

<?php echo htmlspecialchars($train['from_station']); ?>

→

<?php echo htmlspecialchars($train['to_station']); ?>

</p>

</div>

<div class="passenger-card">

<form action="payment.php" method="POST">

<input
type="hidden"
name="train_id"
value="<?php echo $train_id; ?>">

<input
type="hidden"
name="selected_seats"
value="<?php echo htmlspecialchars($selectedSeats); ?>">

<input
type="hidden"
name="total_fare"
value="<?php echo $totalFare; ?>">
<?php

foreach($seatArray as $index=>$seat){

?>

<hr style="margin:35px 0;">

<h2 style="margin-bottom:25px;color:#6A1B9A;">

Passenger <?php echo $index+1; ?>

&nbsp;&nbsp;

(Seat <?php echo htmlspecialchars($seat); ?>)

</h2>

<input
type="hidden"
name="seat_no[]"
value="<?php echo htmlspecialchars($seat); ?>">

<div class="passenger-grid">

<div class="input-box">

<label>Full Name</label>

<input
type="text"
name="passenger_name[]"
required>

</div>

<div class="input-box">

<label>Age</label>

<input
type="number"
name="age[]"
min="1"
max="120"
required>

</div>

<div class="input-box">

<label>Gender</label>

<select
name="gender[]"
required>

<option value="">Select Gender</option>

<option>Male</option>

<option>Female</option>

<option>Other</option>

</select>

</div>

<div class="input-box">

<label>Mobile Number</label>

<input
type="tel"
name="mobile[]"
maxlength="10"
pattern="[0-9]{10}"
placeholder="9876543210"
required>

</div>

<div class="input-box">

<label>Email Address</label>

<input
type="email"
name="email[]"
required>

</div>

<div class="input-box">

<label>ID Proof</label>

<select
name="id_type[]"
required>

<option value="">Select ID</option>

<option>Aadhaar Card</option>

<option>PAN Card</option>

<option>Passport</option>

<option>Driving Licence</option>

<option>Voter ID</option>

</select>

</div>

<div class="input-box">

<label>ID Number</label>

<input
type="text"
name="id_number[]"
required>

</div>

<div class="input-box">

<label>Nationality</label>

<select
name="nationality[]">

<option>Indian</option>

<option>Other</option>

</select>

</div>

<div class="input-box">

<label>Berth Preference</label>

<select
name="berth[]">

<option>No Preference</option>

<option>Lower</option>

<option>Middle</option>

<option>Upper</option>

<option>Side Lower</option>

<option>Side Upper</option>

</select>

</div>

<div class="input-box">

<label>Meal Preference</label>

<select
name="meal[]">

<option>None</option>

<option>Veg</option>

<option>Non-Veg</option>

<option>Jain</option>

</select>

</div>

</div>

<?php

}

?>

<hr style="margin:40px 0;">

<div class="booking-summary">

<h2>

Journey Summary

</h2>

<div class="summary-row">

<span>Train</span>

<strong>

<?php echo htmlspecialchars($train['train_number']); ?>

</strong>

</div>

<div class="summary-row">

<span>Train Name</span>

<strong>

<?php echo htmlspecialchars($train['train_name']); ?>

</strong>

</div>

<div class="summary-row">

<span>Route</span>

<strong>

<?php echo htmlspecialchars($train['from_station']); ?>

→

<?php echo htmlspecialchars($train['to_station']); ?>

</strong>

</div>

<div class="summary-row">

<span>Selected Seats</span>

<strong>

<?php echo htmlspecialchars($selectedSeats); ?>

</strong>

</div>

<div class="summary-row">

<span>Total Passengers</span>

<strong>

<?php echo count($seatArray); ?>

</strong>

</div>

<div class="total-price">

<span>Total Fare</span>

<span>

₹<?php echo number_format($totalFare); ?>

</span>

</div>

<br>

<button
type="submit"
class="search-btn">

Proceed to Secure Payment

</button>

</form>

</div>

</div>

</div>

</section>

<!-- PART 3 STARTS BELOW -->
 <script>

document.addEventListener("DOMContentLoaded",function(){

const form=document.querySelector("form");

form.addEventListener("submit",function(e){

const names=document.querySelectorAll("input[name='passenger_name[]']");
const ages=document.querySelectorAll("input[name='age[]']");
const mobiles=document.querySelectorAll("input[name='mobile[]']");
const emails=document.querySelectorAll("input[name='email[]']");
const ids=document.querySelectorAll("input[name='id_number[]']");

for(let i=0;i<names.length;i++){

if(names[i].value.trim().length<3){

alert("Please enter a valid passenger name.");

names[i].focus();

e.preventDefault();

return;

}

}

for(let i=0;i<ages.length;i++){

if(ages[i].value<1 || ages[i].value>120){

alert("Please enter a valid age.");

ages[i].focus();

e.preventDefault();

return;

}

}

for(let i=0;i<mobiles.length;i++){

if(!/^[0-9]{10}$/.test(mobiles[i].value)){

alert("Please enter a valid 10-digit mobile number.");

mobiles[i].focus();

e.preventDefault();

return;

}

}

for(let i=0;i<emails.length;i++){

if(!emails[i].checkValidity()){

alert("Please enter a valid email address.");

emails[i].focus();

e.preventDefault();

return;

}

}

for(let i=0;i<ids.length;i++){

if(ids[i].value.trim().length<5){

alert("Please enter a valid ID number.");

ids[i].focus();

e.preventDefault();

return;

}

}

});

});

</script>

<?php include "../../includes/layout/footer.php"; ?>

</body>

</html>