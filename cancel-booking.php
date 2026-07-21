<?php
require_once "../config/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($booking_id <= 0) {
    die("Invalid Booking.");
}

$stmt = $conn->prepare("
UPDATE bookings
SET booking_status='Cancelled'
WHERE id=?
");

$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {

    $_SESSION['success'] = "Booking cancelled successfully.";

} else {

    $_SESSION['error'] = "Unable to cancel booking.";

}

header("Location: ../dashboard.php");
exit;
?>