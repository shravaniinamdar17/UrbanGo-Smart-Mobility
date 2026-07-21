<?php
require_once "../config/config.php";

$route_id     = (int)($_POST['route_id'] ?? 0);
$passengers   = (int)($_POST['passengers'] ?? 1);
$seat_numbers = $_POST['seat_numbers'] ?? "";
$total_fare   = (float)($_POST['total_fare'] ?? 0);

if ($route_id <= 0 || $total_fare <= 0) {
    die("Invalid payment request.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Payment | UrbanGo</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/layout/navbar.php"; ?>

<section class="payment-page">

<div class="container">

<h1>Secure Payment</h1>

<div class="payment-wrapper">

<div class="payment-left">

<form action="payment-success.php" method="POST">

<input type="hidden" name="route_id" value="<?= $route_id ?>">

<input type="hidden" name="passengers" value="<?= $passengers ?>">

<input type="hidden" name="seat_numbers" value="<?= htmlspecialchars($seat_numbers) ?>">

<input type="hidden" name="total_fare" value="<?= $total_fare ?>">

<h3>Select Payment Method</h3>

<label class="payment-option">
<input type="radio" name="payment_method" value="UPI" checked>
<span><i class="fa-solid fa-qrcode"></i> UPI</span>
</label>

<label class="payment-option">
<input type="radio" name="payment_method" value="Card">
<span><i class="fa-regular fa-credit-card"></i> Credit / Debit Card</span>
</label>

<label class="payment-option">
<input type="radio" name="payment_method" value="NetBanking">
<span><i class="fa-solid fa-building-columns"></i> Net Banking</span>
</label>

<label class="payment-option">
<input type="radio" name="payment_method" value="Wallet">
<span><i class="fa-solid fa-wallet"></i> Wallet</span>
</label>

<button class="continue-btn">
Pay ₹<?= number_format($total_fare,2) ?>
</button>

</form>

</div>

<div class="payment-right">

<div class="payment-summary">

<h2>Booking Summary</h2>

<p><strong>Passengers:</strong> <?= $passengers ?></p>

<p><strong>Seats:</strong> <?= htmlspecialchars($seat_numbers) ?></p>

<p><strong>Total Amount:</strong></p>

<h1>₹<?= number_format($total_fare,2) ?></h1>

<hr>

<p>

<i class="fa-solid fa-lock"></i>

256-bit Secure Payment

</p>

<p>

<i class="fa-solid fa-shield-halved"></i>

Protected Transaction

</p>

</div>

</div>

</div>

</div>

</section>

</body>

</html>