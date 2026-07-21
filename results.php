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
$class=$_GET['class'] ?? "";
$type=$_GET['type'] ?? "";

$sql="SELECT * FROM train_routes
WHERE from_station=?
AND to_station=?
AND is_active=1";

$params=array($from,$to);
$types="ss";

if($class!=""){

$sql.=" AND train_class=?";

$params[]=$class;

$types.="s";

}

if($type!=""){

$sql.=" AND train_type=?";

$params[]=$type;

$types.="s";

}

$stmt=mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,$types,...$params);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>Available Trains | UrbanGo</title>

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

<section class="results-page">

<div class="container">

<div class="section-title">

<span>

🚆 Available Trains

</span>

<h2>

<?php echo htmlspecialchars($from); ?>

→

<?php echo htmlspecialchars($to); ?>

</h2>

<p>

Journey Date :

<?php echo htmlspecialchars($date); ?>

</p>

</div>
<?php

if(mysqli_num_rows($result)>0){

while($train=mysqli_fetch_assoc($result)){

?>

<div class="train-card">

<div class="train-left">

<h2>

<?php echo htmlspecialchars($train['train_number']); ?>

</h2>

<h3>

<?php echo htmlspecialchars($train['train_name']); ?>

</h3>

<p>

<?php echo htmlspecialchars($train['train_type']); ?>

</p>

<div class="train-badges">

<span>🚆 <?php echo htmlspecialchars($train['train_class']); ?></span>

<span class="available">

<?php echo $train['available_seats']; ?> Seats Left

</span>

<span class="fast">

⚡ Fast

</span>

</div>

</div>

<div class="train-center">

<div class="station-time">

<?php echo date("h:i A",strtotime($train['departure_time'])); ?>

</div>

<div class="station-name">

<?php echo htmlspecialchars($train['from_station']); ?>

</div>

<div class="duration">

<?php echo htmlspecialchars($train['journey_duration']); ?>

</div>

<div class="station-time" style="margin-top:15px;">

<?php echo date("h:i A",strtotime($train['arrival_time'])); ?>

</div>

<div class="station-name">

<?php echo htmlspecialchars($train['to_station']); ?>

</div>

</div>

<div class="train-right">

<h2>

₹<?php echo number_format($train['fare']); ?>

</h2>

<p>

⭐ 4.8 (1,200+ Reviews)

</p>

<a
href="seat-selection.php?id=<?php echo $train['id']; ?>"
class="primary-btn">

Select Coach & Seats

</a>

</div>

</div>

<?php

}

}else{

?>

<div style="background:#fff;
padding:60px;
border-radius:20px;
text-align:center;
box-shadow:0 15px 35px rgba(0,0,0,.08);">

<i class="fa-solid fa-train"
style="font-size:70px;
color:#6A1B9A;
margin-bottom:20px;"></i>

<h2>

No Trains Found

</h2>

<p>

No trains are available for the selected route and date.

Please try another search.

</p>

<br>

<a href="index.php" class="primary-btn">

Search Again

</a>

</div>

<?php

}

?>

</div>

</section>

<?php include "../../includes/layout/footer.php"; ?>

</body>

</html>