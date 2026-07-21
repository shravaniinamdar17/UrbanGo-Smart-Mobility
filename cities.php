<?php
require_once "../config/config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin-login.php");
    exit;
}

$message = "";

/* ===========================
   ADD CITY
=========================== */

if (isset($_POST['add_city'])) {

    $city_name = trim($_POST['city_name']);
    $state = trim($_POST['state']);
    $city_code = strtoupper(trim($_POST['city_code']));
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if ($city_name != "") {

        $stmt = $conn->prepare("
        INSERT INTO cities
        (city_name,state,city_code,is_active)
        VALUES (?,?,?,?)
        ");

        $stmt->bind_param(
            "sssi",
            $city_name,
            $state,
            $city_code,
            $is_active
        );

        if($stmt->execute()){
            $message="City Added Successfully";
        }

    }

}

/* ===========================
   DELETE CITY
=========================== */

if(isset($_GET['delete'])){

    $id=(int)$_GET['delete'];

    $stmt=$conn->prepare("
    DELETE FROM cities
    WHERE id=?
    ");

    $stmt->bind_param("i",$id);
    $stmt->execute();

    header("Location:cities.php");
    exit;

}

/* ===========================
   SEARCH
=========================== */

$search="";

if(isset($_GET['search'])){

    $search=trim($_GET['search']);

}

if($search!=""){

    $stmt=$conn->prepare("
    SELECT *
    FROM cities
    WHERE city_name LIKE ?
    ORDER BY city_name
    ");

    $like="%".$search."%";

    $stmt->bind_param("s",$like);

    $stmt->execute();

    $result=$stmt->get_result();

}else{

    $result=$conn->query("
    SELECT *
    FROM cities
    ORDER BY city_name
    ");

}
?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Manage Cities</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="admin-content">

<h1>

Manage Cities

</h1>

<?php if($message!=""){ ?>

<div class="success-box">

<?= $message ?>

</div>

<?php } ?>

<form method="GET" class="search-form">

<input
type="text"
name="search"
placeholder="Search city..."
value="<?= htmlspecialchars($search) ?>">

<button>

Search

</button>

</form>

<hr>

<h2>

Add New City

</h2>

<form method="POST" class="city-form">

<input
type="text"
name="city_name"
placeholder="City Name"
required>

<input
type="text"
name="state"
placeholder="State"
value="Maharashtra">

<input
type="text"
name="city_code"
placeholder="City Code">

<label>

<input
type="checkbox"
name="is_active"
checked>

Active

</label>

<button
type="submit"
name="add_city">

Add City

</button>

</form>

<hr>

<h2>

City List

</h2>

<table class="admin-table">

<tr>

<th>ID</th>

<th>City</th>

<th>State</th>

<th>Code</th>

<th>Status</th>

<th>Action</th>

</tr>
<tr>

<th>ID</th>

<th>City</th>

<th>State</th>

<th>Code</th>

<th>Status</th>

<th>Action</th>

</tr>