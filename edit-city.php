<?php
require_once "../config/config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin-login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid City ID.");
}

$stmt = $conn->prepare("SELECT * FROM cities WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$city = $stmt->get_result()->fetch_assoc();

if (!$city) {
    die("City not found.");
}

$message = "";

if (isset($_POST['update_city'])) {

    $city_name = trim($_POST['city_name']);
    $state = trim($_POST['state']);
    $city_code = strtoupper(trim($_POST['city_code']));
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $update = $conn->prepare("
        UPDATE cities
        SET city_name=?,
            state=?,
            city_code=?,
            is_active=?
        WHERE id=?
    ");

    $update->bind_param(
        "sssii",
        $city_name,
        $state,
        $city_code,
        $is_active,
        $id
    );

    if ($update->execute()) {

        header("Location: cities.php");
        exit;

    } else {

        $message = "Unable to update city.";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Edit City</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="admin-content">

<h1>Edit City</h1>

<?php if($message!=""){ ?>

<div class="success-box">

<?= $message ?>

</div>

<?php } ?>

<form method="POST" class="city-form">

<input
type="text"
name="city_name"
value="<?= htmlspecialchars($city['city_name']) ?>"
required>

<input
type="text"
name="state"
value="<?= htmlspecialchars($city['state']) ?>"
required>

<input
type="text"
name="city_code"
value="<?= htmlspecialchars($city['city_code']) ?>">

<label>

<input
type="checkbox"
name="is_active"
<?= $city['is_active'] ? "checked" : "" ?>>

Active

</label>

<button
type="submit"
name="update_city">

Save Changes

</button>

</form>

<p style="margin-top:30px;">

<a href="cities.php" class="btn-edit">

← Back to Cities

</a>

</p>

</div>

</body>

</html>