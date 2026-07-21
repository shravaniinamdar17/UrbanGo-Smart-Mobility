<?php
require_once "../config/config.php";

$from = (int)($_GET['from'] ?? 0);
$to = (int)($_GET['to'] ?? 0);
$date = $_GET['date'] ?? date("Y-m-d");
$passengers = (int)($_GET['passengers'] ?? 1);

$sql = "
SELECT
    br.*,
    c1.city_name AS from_city,
    c2.city_name AS to_city
FROM bus_routes br
INNER JOIN cities c1 ON br.from_city = c1.id
INNER JOIN cities c2 ON br.to_city = c2.id
WHERE br.from_city = ?
AND br.to_city = ?
AND br.is_active = 1
ORDER BY br.departure_time
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $from, $to);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Available Buses | UrbanGo</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "../includes/layout/navbar.php"; ?>

<section class="results-page">

<div class="container">

<h1>Available Buses</h1>

<p>

<?= htmlspecialchars($date) ?>

</p>

<?php if($result->num_rows==0){ ?>

<div class="no-results">

<h2>No buses found.</h2>

<p>

Try another date or destination.

</p>

</div>

<?php } ?>

<?php while($bus=$result->fetch_assoc()){ ?>

<div class="bus-card">

<div class="bus-left">

<h2>

<?= htmlspecialchars($bus['operator_name']) ?>

</h2>

<h3>

<?= htmlspecialchars($bus['from_city']) ?>

<i class="fa-solid fa-arrow-right"></i>

<?= htmlspecialchars($bus['to_city']) ?>

</h3>

<p>

Departure :
<?= date("h:i A",strtotime($bus['departure_time'])) ?>

</p>

<p>

Arrival :
<?= date("h:i A",strtotime($bus['arrival_time'])) ?>

</p>

</div>

<div class="bus-center">

<div>

⭐ 4.8

</div>

<div>

Seats :
<?= $bus['available_seats'] ?>

</div>

<div>

AC Sleeper

</div>

</div>

<div class="bus-right">

<h2>

₹<?= number_format($bus['fare']) ?>

</h2>

<a

class="book-btn"

href="seat-selection.php?route=<?= $bus['id'] ?>&passengers=<?= $passengers ?>">

Book Now

</a>

</div>

</div>

<?php } ?>

</div>

</section>

</body>

</html>