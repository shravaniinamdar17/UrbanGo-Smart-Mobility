<?php
require_once "../config/config.php";

$route_id = isset($_POST['route_id']) ? (int)$_POST['route_id'] : 0;
$passengers = isset($_POST['passengers']) ? (int)$_POST['passengers'] : 1;
$seat_numbers = $_POST['seat_numbers'] ?? "";

if ($route_id <= 0 || empty($seat_numbers)) {
    die("Invalid booking request.");
}

$stmt = $conn->prepare("SELECT * FROM bus_routes WHERE id=?");
$stmt->bind_param("i", $route_id);
$stmt->execute();
$bus = $stmt->get_result()->fetch_assoc();

$totalFare = $bus['fare'] * $passengers;
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Passenger Details | UrbanGo</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/layout/navbar.php"; ?>

<section class="passenger-page">

<div class="container">

<h1>Passenger Details</h1>

<form action="payment.php" method="POST">

<input type="hidden" name="route_id" value="<?= $route_id ?>">

<input type="hidden" name="seat_numbers" value="<?= htmlspecialchars($seat_numbers) ?>">

<input type="hidden" name="passengers" value="<?= $passengers ?>">

<input type="hidden" name="total_fare" value="<?= $totalFare ?>">

<div class="passenger-grid">

<?php for($i=1;$i<=$passengers;$i++){ ?>

<div class="passenger-card">

<h3>Passenger <?= $i ?></h3>

<input
type="text"
name="name[]"
placeholder="Full Name"
required>

<input
type="number"
name="age[]"
placeholder="Age"
required>

<select name="gender[]" required>

<option value="">Gender</option>

<option>Male</option>

<option>Female</option>

<option>Other</option>

</select>

</div>

<?php } ?>

</div>

<div class="contact-card">

<h2>Contact Information</h2>

<input
type="text"
name="mobile"
placeholder="Mobile Number"
required>

<input
type="email"
name="email"
placeholder="Email Address"
required>

</div>

<div class="fare-summary">

<h2>Total Amount</h2>

<h1>₹<?= number_format($totalFare) ?></h1>

<p>

Seats:
<?= htmlspecialchars($seat_numbers) ?>

</p>

</div>

<button class="continue-btn">

Proceed To Payment

</button>

</form>

</div>

</section>

</body>

</html>