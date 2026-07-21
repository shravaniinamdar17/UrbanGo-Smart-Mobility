<?php
require_once "../config/config.php";

$route_id = (int)($_POST['route_id'] ?? 0);
$passengers = (int)($_POST['passengers'] ?? 1);
$seat_numbers = trim($_POST['seat_numbers'] ?? '');
$total_amount = (float)($_POST['total_fare'] ?? 0);
$payment_method = trim($_POST['payment_method'] ?? 'UPI');

if ($route_id <= 0 || $seat_numbers === '' || $total_amount <= 0) {
    die("Invalid booking request.");
}

$booking_number = "UG" . date("Ymd") . rand(10000,99999);
$transaction_id = "TXN" . strtoupper(substr(md5(uniqid()),0,12));

$conn->begin_transaction();

try {

    $stmt = $conn->prepare("
        INSERT INTO bookings
        (booking_number,route_id,passenger_count,seat_numbers,total_amount,payment_method,payment_status,booking_status)
        VALUES (?,?,?,?,?,?, 'Paid','Confirmed')
    ");

    $stmt->bind_param(
        "siisss",
        $booking_number,
        $route_id,
        $passengers,
        $seat_numbers,
        $total_amount,
        $payment_method
    );

    $stmt->execute();

    $booking_id = $conn->insert_id;

    if(isset($_POST['name'])){

        for($i=0;$i<count($_POST['name']);$i++){

            $name=$_POST['name'][$i];
            $age=(int)$_POST['age'][$i];
            $gender=$_POST['gender'][$i];

            $p=$conn->prepare("
            INSERT INTO booking_passengers
            (booking_id,passenger_name,age,gender)
            VALUES (?,?,?,?)
            ");

            $p->bind_param(
                "isis",
                $booking_id,
                $name,
                $age,
                $gender
            );

            $p->execute();

        }

    }

    $pay=$conn->prepare("
    INSERT INTO payments
    (booking_id,transaction_id,payment_method,amount,payment_status)
    VALUES (?,?,?,?, 'Success')
    ");

    $pay->bind_param(
        "issd",
        $booking_id,
        $transaction_id,
        $payment_method,
        $total_amount
    );

    $pay->execute();

    $conn->commit();

    header("Location: ticket.php?id=".$booking_id);

    exit;

}catch(Exception $e){

    $conn->rollback();

    die($e->getMessage());

}
?>