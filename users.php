<?php
require_once "../config/config.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin-login.php");
    exit;
}

$search = $_GET['search'] ?? "";

if ($search != "") {

    $stmt = $conn->prepare("
    SELECT *
    FROM users
    WHERE username LIKE ?
    OR email LIKE ?
    ORDER BY id DESC
    ");

    $like = "%".$search."%";

    $stmt->bind_param("ss",$like,$like);

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $result = $conn->query("
    SELECT *
    FROM users
    ORDER BY id DESC
    ");

}
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>User Management</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "navbar.php"; ?>

<div class="admin-content">

<h1>

User Management

</h1>

<form method="GET" class="search-form">

<input
type="text"
name="search"
placeholder="Search username or email..."
value="<?= htmlspecialchars($search) ?>">

<button>

Search

</button>

</form>

<table class="admin-table">

<tr>

<th>ID</th>

<th>Photo</th>

<th>Full Name</th>

<th>Username</th>

<th>Email</th>

<th>Phone</th>

<th>Role</th>

<th>Status</th>

<th>Wallet</th>

<th>Reward Points</th>

<th>Email</th>

<th>Phone</th>

<th>Action</th>

</tr>
<?php while($user = $result->fetch_assoc()){ ?>

<tr>

<td><?= $user['id'] ?></td>

<td>

<img
src="../uploads/profile/<?= htmlspecialchars($user['profile_picture']) ?>"
width="45"
height="45"
style="border-radius:50%;object-fit:cover;">

</td>

<td>

<?= htmlspecialchars($user['fullname']) ?>

</td>

<td>

<?= htmlspecialchars($user['username']) ?>

</td>

<td>

<?= htmlspecialchars($user['email']) ?>

</td>

<td>

<?= htmlspecialchars($user['phone']) ?>

</td>

<td>

<span class="badge">

<?= ucfirst($user['role']) ?>

</span>

</td>

<td>

<?php if($user['status']=="Active"){ ?>

<span class="badge active">

Active

</span>

<?php }else{ ?>

<span class="badge inactive">

Blocked

</span>

<?php } ?>

</td>

<td>

₹<?= number_format($user['wallet'],2) ?>

</td>

<td>

<?= $user['reward_points'] ?>

</td>

<td>

<?php

echo $user['email_verified']
? '<span class="badge active">Verified</span>'
: '<span class="badge inactive">Not Verified</span>';

?>

</td>

<td>

<?php

echo $user['phone_verified']
? '<span class="badge active">Verified</span>'
: '<span class="badge inactive">Not Verified</span>';

?>

</td>

<td>

<div class="action-buttons">

<a
href="edit-user.php?id=<?= $user['id'] ?>"
class="btn-edit">

Edit

</a>

<a
href="toggle-user.php?id=<?= $user['id'] ?>"
class="btn-edit">

<?= $user['status']=="Active" ? "Block" : "Unblock" ?>

</a>

<a
href="delete-user.php?id=<?= $user['id'] ?>"
class="btn-delete"
onclick="return confirm('Delete this user?')">

Delete

</a>

</div>

</td>

</tr>

<?php } ?>