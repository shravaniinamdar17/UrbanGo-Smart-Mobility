<?php
require_once "../config/config.php";

$totalUsers = $conn->query("SELECT COUNT(*) total FROM users")->fetch_assoc()['total'];

$totalBookings = $conn->query("SELECT COUNT(*) total FROM bookings")->fetch_assoc()['total'];

$totalCities = $conn->query("SELECT COUNT(*) total FROM cities")->fetch_assoc()['total'];

$totalRoutes = $conn->query("SELECT COUNT(*) total FROM bus_routes")->fetch_assoc()['total'];

$totalRevenue = $conn->query("SELECT IFNULL(SUM(total_amount),0) total FROM bookings WHERE payment_status='Paid'")->fetch_assoc()['total'];
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Admin Dashboard</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="admin-content">

<h1>Dashboard</h1>

<div class="cards">

<div class="card">

<h2><?= $totalUsers ?></h2>

<p>Users</p>

</div>

<div class="card">

<h2><?= $totalBookings ?></h2>

<p>Bookings</p>

</div>

<div class="card">

<h2><?= $totalCities ?></h2>

<p>Cities</p>

</div>

<div class="card">

<h2><?= $totalRoutes ?></h2>

<p>Routes</p>

</div>

<div class="card">

<h2>₹<?= number_format($totalRevenue) ?></h2>

<p>Revenue</p>

</div>

</div>

</div>

</body>

</html>