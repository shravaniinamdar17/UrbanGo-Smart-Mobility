<?php
session_start();
require_once "config/db_connect.php";

/* User must be logged in */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$fullname = $_SESSION['full_name'];
$username = $_SESSION['username'];
$email    = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard | UrbanGo Smart Mobility</title>

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/dashboard.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="dashboard">

<!-- ================= SIDEBAR ================= -->

<div class="sidebar">

<div class="logo">

<h2>

<i class="fa-solid fa-route"></i>

UrbanGo

</h2>

</div>

<ul>

<li class="active">
<a href="dashboard.php">

<i class="fa-solid fa-house"></i>

Dashboard

</a>
</li>

<li>
<a href="booking/bus/">

<i class="fa-solid fa-bus"></i>

Bus Booking

</a>
</li>

<li>
<a href="booking/train/">

<i class="fa-solid fa-train"></i>

Train Booking

</a>
</li>

<li>
<a href="booking/metro/">

<i class="fa-solid fa-train-subway"></i>

Metro Booking

</a>
</li>

<li>
<a href="booking/cab/">

<i class="fa-solid fa-taxi"></i>

Cab Booking

</a>
</li>

<li>
<a href="booking/ev/">

<i class="fa-solid fa-bolt"></i>

EV Charging

</a>
</li>

<li>
<a href="tickets/">

<i class="fa-solid fa-ticket"></i>

My Tickets

</a>
</li>

<li>
<a href="payments/">

<i class="fa-solid fa-credit-card"></i>

Payments

</a>
</li>

<li>
<a href="profile.php">

<i class="fa-solid fa-user"></i>

Profile

</a>
</li>

<li>
<a href="logout.php">

<i class="fa-solid fa-right-from-bracket"></i>

Logout

</a>
</li>

</ul>

</div>

<!-- ================= MAIN CONTENT ================= -->

<div class="main-content">

<!-- ================= TOP BAR ================= -->

<div class="topbar">

<div class="left">

<h1>

Dashboard

</h1>

</div>

<div class="right">

<div class="notification">

<i class="fa-solid fa-bell"></i>

<span class="badge">3</span>

</div>

<div class="user-box">

<img
src="assets/images/default-user.png"
alt="User">

<div>

<h4>

<?php echo htmlspecialchars($fullname); ?>

</h4>

<p>

<?php echo htmlspecialchars($email); ?>

</p>

</div>

</div>

</div>

</div>

<!-- ================= WELCOME SECTION ================= -->

<section class="welcome">

<h2>

👋 Welcome,

<?php echo htmlspecialchars($fullname); ?>

</h2>

<p>

Welcome back to UrbanGo Smart Mobility Platform.

Book Bus, Train, Metro, Cab and EV Charging anytime across India.

</p>

</section>

<!-- PART 2 STARTS BELOW -->
 <!-- =========================================================
        BOOKING MODULES
========================================================= -->

<section class="booking-grid">

<a href="booking/bus/index.php" class="booking-card bus">

<div class="icon">
<i class="fa-solid fa-bus"></i>
</div>

<h2>Bus Booking</h2>

<p>
Search, compare and book AC, Sleeper,
Volvo and Electric buses across India.
</p>

<div class="booking-footer">

<span>Book Now</span>

<i class="fa-solid fa-arrow-right"></i>

</div>

</a>

<a href="booking/train/index.php" class="booking-card train">

<div class="icon">
<i class="fa-solid fa-train"></i>
</div>

<h2>Train Booking</h2>

<p>
Book Express, Rajdhani, Shatabdi,
Vande Bharat and more.
</p>

<div class="booking-footer">

<span>Book Now</span>

<i class="fa-solid fa-arrow-right"></i>

</div>

</a>

<a href="booking/metro/index.php" class="booking-card metro">

<div class="icon">
<i class="fa-solid fa-train-subway"></i>
</div>

<h2>Metro Booking</h2>

<p>

Generate instant QR tickets
for metro travel.

</p>

<div class="booking-footer">

<span>Book Now</span>

<i class="fa-solid fa-arrow-right"></i>

</div>

</a>

<a href="booking/cab/index.php" class="booking-card cab">

<div class="icon">
<i class="fa-solid fa-taxi"></i>
</div>

<h2>Cab Booking</h2>

<p>

Book Mini, Sedan, SUV,
Luxury and EV taxis.

</p>

<div class="booking-footer">

<span>Book Now</span>

<i class="fa-solid fa-arrow-right"></i>

</div>

</a>

<a href="booking/ev/index.php" class="booking-card ev">

<div class="icon">
<i class="fa-solid fa-bolt"></i>
</div>

<h2>EV Charging</h2>

<p>

Find nearby charging stations
and reserve slots instantly.

</p>

<div class="booking-footer">

<span>Reserve Slot</span>

<i class="fa-solid fa-arrow-right"></i>

</div>

</a>

</section>


<!-- =========================================================
        QUICK ACTIONS
========================================================= -->

<section class="quick-actions">

<div class="action-card">

<i class="fa-solid fa-ticket"></i>

<h3>My Tickets</h3>

<p>

View, download and print
all booked tickets.

</p>

<a href="tickets/index.php">

Open

</a>

</div>


<div class="action-card">

<i class="fa-solid fa-credit-card"></i>

<h3>Payment History</h3>

<p>

Check all successful
transactions and receipts.

</p>

<a href="payments/history.php">

Open

</a>

</div>


<div class="action-card">

<i class="fa-solid fa-percent"></i>

<h3>Offers & Coupons</h3>

<p>

Save more with
exclusive UrbanGo offers.

</p>

<a href="offers.php">

View Offers

</a>

</div>


<div class="action-card">

<i class="fa-solid fa-headset"></i>

<h3>24×7 Support</h3>

<p>

Need help?
Chat with UrbanGo support.

</p>

<a href="chatbot/index.php">

Chat Now

</a>

</div>

</section>

<!-- PART 3 STARTS BELOW -->
 <!-- ==========================================================
                DASHBOARD STATISTICS
========================================================== -->

<section class="stats-grid">

<div class="stat-card">

<div class="stat-icon blue">
<i class="fa-solid fa-ticket"></i>
</div>

<div class="stat-content">
<h2>18</h2>
<p>Total Bookings</p>
</div>

</div>


<div class="stat-card">

<div class="stat-icon green">
<i class="fa-solid fa-indian-rupee-sign"></i>
</div>

<div class="stat-content">
<h2>₹24,560</h2>
<p>Total Payments</p>
</div>

</div>


<div class="stat-card">

<div class="stat-icon orange">
<i class="fa-solid fa-star"></i>
</div>

<div class="stat-content">
<h2>4.9</h2>
<p>User Rating</p>
</div>

</div>


<div class="stat-card">

<div class="stat-icon purple">
<i class="fa-solid fa-gift"></i>
</div>

<div class="stat-content">
<h2>8</h2>
<p>Available Offers</p>
</div>

</div>

</section>



<!-- ==========================================================
                RECENT BOOKINGS
========================================================== -->

<div class="dashboard-row">

<div class="recent-bookings">

<div class="section-header">

<h2>

<i class="fa-solid fa-clock-rotate-left"></i>

Recent Bookings

</h2>

<a href="tickets/index.php">

View All

</a>

</div>

<table>

<thead>

<tr>

<th>ID</th>
<th>Service</th>
<th>Route</th>
<th>Status</th>
<th>Amount</th>

</tr>

</thead>

<tbody>

<tr>

<td>UG1001</td>

<td>

🚌 Bus

</td>

<td>

Mumbai → Pune

</td>

<td>

<span class="success">

Confirmed

</span>

</td>

<td>

₹899

</td>

</tr>

<tr>

<td>UG1002</td>

<td>

🚆 Train

</td>

<td>

Delhi → Chandigarh

</td>

<td>

<span class="success">

Confirmed

</span>

</td>

<td>

₹650

</td>

</tr>

<tr>

<td>UG1003</td>

<td>

🚕 Cab

</td>

<td>

Airport → Hotel

</td>

<td>

<span class="pending">

Running

</span>

</td>

<td>

₹420

</td>

</tr>

<tr>

<td>UG1004</td>

<td>

⚡ EV

</td>

<td>

Charge Station A

</td>

<td>

<span class="success">

Completed

</span>

</td>

<td>

₹310

</td>

</tr>

</tbody>

</table>

</div>



<!-- ==========================================================
                LIVE NOTIFICATIONS
========================================================== -->

<div class="notification-panel">

<div class="section-header">

<h2>

🔔 Notifications

</h2>

</div>

<div class="notification-item">

<div class="notify-icon">

✅

</div>

<div>

<h4>

Payment Successful

</h4>

<p>

Your Mumbai → Pune bus ticket has been booked.

</p>

</div>

</div>

<div class="notification-item">

<div class="notify-icon">

🎁

</div>

<div>

<h4>

Special Offer

</h4>

<p>

Use coupon <b>WELCOME10</b> and save 10%.

</p>

</div>

</div>

<div class="notification-item">

<div class="notify-icon">

⚡

</div>

<div>

<h4>

EV Charging Slot

</h4>

<p>

Your charging slot starts in 30 minutes.

</p>

</div>

</div>

<div class="notification-item">

<div class="notify-icon">

🚆

</div>

<div>

<h4>

Train Reminder

</h4>

<p>

Vande Bharat departs tomorrow at 06:20 AM.

</p>

</div>

</div>

</div>

</div>



<!-- ==========================================================
                UPCOMING JOURNEY
========================================================== -->

<section class="journey-card">

<div>

<h2>

Upcoming Journey

</h2>

<h3>

🚌 Mumbai → Pune

</h3>

<p>

Operator : VRL Volvo

</p>

<p>

Seat : A12

</p>

<p>

Departure : 10:30 PM

</p>

</div>

<div>

<a href="tickets/index.php" class="primary-btn">

View Ticket

</a>

</div>

</section>

<!-- PART 4 STARTS BELOW -->
 <!-- ==========================================================
                QUICK ACCESS
========================================================== -->

<section class="quick-links">

<a href="profile.php" class="quick-box">
<i class="fa-solid fa-user"></i>
<h3>Profile</h3>
<p>Manage your account</p>
</a>

<a href="payments/history.php" class="quick-box">
<i class="fa-solid fa-wallet"></i>
<h3>Wallet</h3>
<p>Payment History</p>
</a>

<a href="offers.php" class="quick-box">
<i class="fa-solid fa-gift"></i>
<h3>Offers</h3>
<p>Latest Discounts</p>
</a>

<a href="settings.php" class="quick-box">
<i class="fa-solid fa-gear"></i>
<h3>Settings</h3>
<p>Manage Preferences</p>
</a>

</section>


<!-- ==========================================================
                AI CHATBOT
========================================================== -->

<div class="chatbot-button">

<a href="chatbot/index.php">

<i class="fa-solid fa-robot"></i>

</a>

</div>


<!-- ==========================================================
                DARK MODE BUTTON
========================================================== -->

<button id="darkModeBtn" class="dark-mode-btn">

<i class="fa-solid fa-moon"></i>

</button>


<!-- ==========================================================
                FOOTER
========================================================== -->

<footer class="dashboard-footer">

<p>

© <?php echo date("Y"); ?>

UrbanGo Smart Mobility

| Made with ❤️ in India

</p>

</footer>

</div>

</div>

<script>

const darkBtn=document.getElementById("darkModeBtn");

darkBtn.onclick=function(){

document.body.classList.toggle("dark");

}

</script>

</body>

</html>