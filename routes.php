<?php
require_once "../config/config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin-login.php");
    exit;
}

$message = "";

/* ===========================
   ADD ROUTE
=========================== */

if(isset($_POST['add_route'])){

    $operator = trim($_POST['operator_name']);
    $bus_name = trim($_POST['bus_name']);
    $bus_type = trim($_POST['bus_type']);

    $from_city = (int)$_POST['from_city'];
    $to_city = (int)$_POST['to_city'];
        $departure_time = $_POST['departure_time'];
    $arrival_time   = $_POST['arrival_time'];

    $fare = (float)$_POST['fare'];
    $total_seats = (int)$_POST['total_seats'];
    $available_seats = (int)$_POST['available_seats'];

    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $stmt = $conn->prepare("
    INSERT INTO bus_routes
    (
        operator_name,
        bus_name,
        bus_type,
        from_city,
        to_city,
        departure_time,
        arrival_time,
        fare,
        total_seats,
        available_seats,
        is_active
    )
    VALUES
    (?,?,?,?,?,?,?,?,?,?,?)
    ");

    $stmt->bind_param(
        "sssiiisddii",
        $operator,
        $bus_name,
        $bus_type,
        $from_city,
        $to_city,
        $departure_time,
        $arrival_time,
        $fare,
        $total_seats,
        $available_seats,
        $is_active
    );

    if($stmt->execute()){
        $message="Route Added Successfully";
    }else{
        $message="Error : ".$conn->error;
    }

}

/* ===========================
   LOAD CITIES
=========================== */

$cities=[];

$result=$conn->query("
SELECT id,city_name
FROM cities
WHERE is_active=1
ORDER BY city_name
");

while($row=$result->fetch_assoc()){
    $cities[]=$row;
}

/* ===========================
   ROUTE LIST
=========================== */

$routes=$conn->query("
SELECT
br.*,
c1.city_name AS from_city_name,
c2.city_name AS to_city_name
FROM bus_routes br
JOIN cities c1 ON br.from_city=c1.id
JOIN cities c2 ON br.to_city=c2.id
ORDER BY br.id DESC
");
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>Manage Routes</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="admin-content">

<h1>

Manage Bus Routes

</h1>

<?php if($message!=""){ ?>

<div class="success-box">

<?= $message ?>

</div>

<?php } ?>

<form method="POST" class="route-form">

<input
type="text"
name="operator_name"
placeholder="Operator Name"
required>

<input
type="text"
name="bus_name"
placeholder="Bus Name"
required>

<select
name="bus_type"
required>

<option value="">Bus Type</option>

<option>AC Sleeper</option>

<option>AC Seater</option>

<option>Non AC Sleeper</option>

<option>Non AC Seater</option>

<option>Luxury Volvo</option>

</select>

<select
name="from_city"
required>

<option value="">From City</option>

<?php foreach($cities as $city){ ?>

<option value="<?= $city['id'] ?>">

<?= htmlspecialchars($city['city_name']) ?>

</option>

<?php } ?>

</select>

<select
name="to_city"
required>

<option value="">To City</option>

<?php foreach($cities as $city){ ?>

<option value="<?= $city['id'] ?>">

<?= htmlspecialchars($city['city_name']) ?>

</option>

<?php } ?>

</select>
<div class="route-grid">

<div>

<label>Departure Time</label>

<input
type="time"
name="departure_time"
required>

</div>

<div>

<label>Arrival Time</label>

<input
type="time"
name="arrival_time"
required>

</div>

<div>

<label>Fare (₹)</label>

<input
type="number"
name="fare"
min="1"
step="0.01"
placeholder="500"
required>

</div>

<div>

<label>Total Seats</label>

<input
type="number"
name="total_seats"
value="40"
required>

</div>

<div>

<label>Available Seats</label>

<input
type="number"
name="available_seats"
value="40"
required>

</div>

<div class="checkbox-box">

<label>

<input
type="checkbox"
name="is_active"
checked>

Route Active

</label>

</div>

</div>

<button
type="submit"
name="add_route"
class="save-btn">

<i class="fa-solid fa-plus"></i>

Add Route

</button>

</form>

<hr>

<h2>

Available Routes

</h2>

<table class="admin-table">

<tr>

<th>ID</th>

<th>Operator</th>

<th>Bus</th>

<th>Type</th>

<th>Route</th>

<th>Time</th>

<th>Fare</th>

<th>Seats</th>

<th>Status</th>

<th>Action</th>

</tr>

<?php while($route=$routes->fetch_assoc()){ ?>

<tr>

<td>

<?= $route['id'] ?>

</td>

<td>

<?= htmlspecialchars($route['operator_name']) ?>

</td>

<td>

<?= htmlspecialchars($route['bus_name']) ?>

</td>

<td>

<?= htmlspecialchars($route['bus_type']) ?>

</td>

<td>

<?= htmlspecialchars($route['from_city_name']) ?>

<br>

↓

<br>

<?= htmlspecialchars($route['to_city_name']) ?>

</td>

<td>

<?= date("h:i A",strtotime($route['departure_time'])) ?>

<br>

↓

<br>

<?= date("h:i A",strtotime($route['arrival_time'])) ?>

</td>

<td>

₹<?= number_format($route['fare']) ?>

</td>

<td>

<?= $route['available_seats'] ?>

/

<?= $route['total_seats'] ?>

</td>

<td>

<?php if($route['is_active']){ ?>

<span class="badge active">

Active

</span>

<?php }else{ ?>

<span class="badge inactive">

Inactive

</span>

<?php } ?>

</td>

<td>

<a
href="edit-route.php?id=<?= $route['id'] ?>"
class="btn-edit">

Edit

</a>

<a
href="delete-route.php?id=<?= $route['id'] ?>"
class="btn-delete"
onclick="return confirm('Delete this route?');">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>