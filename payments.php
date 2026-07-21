<?php
require_once "../config/config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin-login.php");
    exit;
}

$search = $_GET['search'] ?? "";

if ($search != "") {

    $stmt = $conn->prepare("
    SELECT
        p.*,
        b.booking_number,
        u.fullname,
        u.email
    FROM payments p
    JOIN bookings b ON p.booking_id = b.id
    JOIN users u ON b.user_id = u.id
    WHERE
        p.transaction_id LIKE ?
        OR b.booking_number LIKE ?
        OR u.fullname LIKE ?
    ORDER BY p.created_at DESC
    ");

    $like = "%".$search."%";

    $stmt->bind_param("sss",$like,$like,$like);
    $stmt->execute();
    $payments = $stmt->get_result();

} else {

    $payments = $conn->query("
    SELECT
        p.*,
        b.booking_number,
        u.fullname,
        u.email
    FROM payments p
    JOIN bookings b ON p.booking_id=b.id
    JOIN users u ON b.user_id=u.id
    ORDER BY p.created_at DESC
    ");

}

$totalRevenue = $conn->query("
SELECT IFNULL(SUM(amount),0) total
FROM payments
WHERE payment_status='Success'
")->fetch_assoc()['total'];

$totalTransactions = $conn->query("
SELECT COUNT(*) total
FROM payments
")->fetch_assoc()['total'];

$successful = $conn->query("
SELECT COUNT(*) total
FROM payments
WHERE payment_status='Success'
")->fetch_assoc()['total'];

$failed = $conn->query("
SELECT COUNT(*) total
FROM payments
WHERE payment_status='Failed'
")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Payments</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="admin-content">

<h1>Payments</h1>

<div class="cards">

<div class="card">
<h2>₹<?= number_format($totalRevenue,2) ?></h2>
<p>Total Revenue</p>
</div>

<div class="card">
<h2><?= $totalTransactions ?></h2>
<p>Total Transactions</p>
</div>

<div class="card">
<h2><?= $successful ?></h2>
<p>Successful</p>
</div>

<div class="card">
<h2><?= $failed ?></h2>
<p>Failed</p>
</div>

</div>

<form method="GET" class="search-form">

<input
type="text"
name="search"
placeholder="Search Transaction / Booking / User"
value="<?= htmlspecialchars($search) ?>">

<button>

Search

</button>

</form>

<table class="admin-table">

<tr>

<th>Transaction</th>

<th>Booking</th>

<th>User</th>

<th>Amount</th>

<th>Method</th>

<th>Status</th>

<th>Date</th>

</tr>
<?php while($payment = $payments->fetch_assoc()){ ?>

<tr>

<td>

<strong>

<?= htmlspecialchars($payment['transaction_id']) ?>

</strong>

</td>

<td>

<?= htmlspecialchars($payment['booking_number']) ?>

</td>

<td>

<?= htmlspecialchars($payment['fullname']) ?>

<br>

<small>

<?= htmlspecialchars($payment['email']) ?>

</small>

</td>

<td>

₹<?= number_format($payment['amount'],2) ?>

</td>

<td>

<?= htmlspecialchars($payment['payment_method']) ?>

</td>

<td>

<?php

$status = strtolower($payment['payment_status']);

if($status=="success"){

?>

<span class="badge active">

Success

</span>

<?php

}elseif($status=="failed"){

?>

<span class="badge inactive">

Failed

</span>

<?php

}else{

?>

<span class="badge">

<?= htmlspecialchars($payment['payment_status']) ?>

</span>

<?php } ?>

</td>

<td>

<?= date("d M Y",strtotime($payment['created_at'])) ?>

<br>

<small>

<?= date("h:i A",strtotime($payment['created_at'])) ?>

</small>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>

</html>