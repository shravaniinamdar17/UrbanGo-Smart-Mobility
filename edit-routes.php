<?php
require_once "../config/config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin-login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid Route ID");
}

$stmt = $conn->prepare("SELECT * FROM bus_routes WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$route = $stmt->get_result()->fetch_assoc();

if (!$route) {
    die("Route not found.");
}

$cities = [];
$result = $conn->query("
SELECT id, city_name
FROM cities
WHERE is_active=1
ORDER BY city_name
");

while($row = $result->fetch_assoc()){
    $cities[] = $row;
}

if(isset($_POST['update_route'])){

    $operator = trim($_POST['operator_name']);
    $bus_name = trim($_POST['bus_name']);
    $bus_type = trim($_POST['bus_type']);

    $from_city = (int)$_POST['from_city'];
    $to_city = (int)$_POST['to_city'];

    $departure = $_POST['departure_time'];
    $arrival = $_POST['arrival_time'];

    $fare = (float)$_POST['fare'];

    $total = (int)$_POST['total_seats'];
    $available = (int)$_POST['available_seats'];

    $active = isset($_POST['is_active']) ? 1 : 0;

    $update = $conn->prepare("
    UPDATE bus_routes
    SET
        operator_name=?,
        bus_name=?,
        bus_type=?,
        from_city=?,
        to_city=?,
        departure_time=?,
        arrival_time=?,
        fare=?,
        total_seats=?,
        available_seats=?,
        is_active=?
    WHERE id=?
    ");

    $update->bind_param(
        "sssiiisddiii",
        $operator,
        $bus_name,
        $bus_type,
        $from_city,
        $to_city,
        $departure,
        $arrival,
        $fare,
        $total,
        $available,
        $active,
        $id
    );

    if($update->execute()){

        header("Location: routes.php");
        exit;

    }

}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Edit Route</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="admin-content">

<h1>Edit Route</h1>

<form method="POST" class="route-form">

<input
type="text"
name="operator_name"
value="<?= htmlspecialchars($route['operator_name']) ?>"
required>

<input
type="text"
name="bus_name"
value="<?= htmlspecialchars($route['bus_name']) ?>"
required>

<select name="bus_type">

<option <?= $route['bus_type']=="AC Sleeper"?"selected":"" ?>>
AC Sleeper
</option>

<option <?= $route['bus_type']=="AC Seater"?"selected":"" ?>>
AC Seater
</option>

<option <?= $route['bus_type']=="Non AC Sleeper"?"selected":"" ?>>
Non AC Sleeper
</option>

<option <?= $route['bus_type']=="Non AC Seater"?"selected":"" ?>>
Non AC Seater
</option>

<option <?= $route['bus_type']=="Luxury Volvo"?"selected":"" ?>>
Luxury Volvo
</option>

</select>

<select name="from_city">

<?php foreach($cities as $city){ ?>

<option
value="<?= $city['id'] ?>"
<?= $city['id']==$route['from_city']?"selected":"" ?>>

<?= htmlspecialchars($city['city_name']) ?>

</option>

<?php } ?>

</select>

<select name="to_city">

<?php foreach($cities as $city){ ?>

<option
value="<?= $city['id'] ?>"
<?= $city['id']==$route['to_city']?"selected":"" ?>>

<?= htmlspecialchars($city['city_name']) ?>

</option>

<?php } ?>

</select>

<div class="route-grid">

<input
type="time"
name="departure_time"
value="<?= $route['departure_time'] ?>">

<input
type="time"
name="arrival_time"
value="<?= $route['arrival_time'] ?>">

<input
type="number"
name="fare"
value="<?= $route['fare'] ?>">

<input
type="number"
name="total_seats"
value="<?= $route['total_seats'] ?>">

<input
type="number"
name="available_seats"
value="<?= $route['available_seats'] ?>">

<label>

<input
type="checkbox"
name="is_active"
<?= $route['is_active'] ? "checked" : "" ?>>

Active

</label>

</div>

<button
type="submit"
name="update_route"
class="save-btn">

Update Route

</button>

</form>

</div>

</body>

</html>