<?php
session_start();

require_once "config/db_connect.php";

$error = "";

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password)){

        $error = "Please fill all fields.";

    }else{

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id,full_name,username,email,password
             FROM users
             WHERE email=?"
        );

        mysqli_stmt_bind_param($stmt,"s",$email);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result)==1){

            $user = mysqli_fetch_assoc($result);

            if(password_verify($password,$user['password'])){

                $_SESSION['user_id']       = $user['id'];
                $_SESSION['full_name']     = $user['full_name'];
                $_SESSION['username']      = $user['username'];
                $_SESSION['user_email']    = $user['email'];

                header("Location: dashboard.php");
                exit;

            }else{

                $error="Incorrect Password.";

            }

        }else{

            $error="Email not registered.";

        }

    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | UrbanGo Smart Mobility</title>

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/login.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "includes/layout/navbar.php"; ?>

<section class="login-page">

<div class="login-container">

<div class="login-left">

<h1>

Welcome Back 👋

</h1>

<p>

Login to UrbanGo and book Buses, Trains, Metro, Cab and EV Charging Stations across India.

</p>

<img
src="assets/images/login-illustration.png"
alt="UrbanGo Login">

</div>

<div class="login-right">

<div class="login-card">

<h2>

User Login

</h2>

<p>

Access your UrbanGo account

</p>

<?php if($error!=""){ ?>

<div class="error-box">

<i class="fa-solid fa-circle-xmark"></i>

<?php echo $error; ?>

</div>

<?php } ?>

<form method="POST">

<div class="form-group">

<label>

<i class="fa-solid fa-envelope"></i>

Email Address

</label>

<input
type="email"
name="email"
placeholder="Enter Email Address"
required>

</div>

<div class="form-group">

<label>

<i class="fa-solid fa-lock"></i>

Password

</label>

<div class="password-box">

<input
type="password"
id="password"
name="password"
placeholder="Enter Password"
required>

<i
class="fa-solid fa-eye toggle-password"
onclick="togglePassword()"></i>

</div>

</div>

<div class="login-options">

<label>

<input type="checkbox">

Remember Me

</label>

<a href="#">

Forgot Password?

</a>

</div>

<button
type="submit"
class="login-btn">

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>

<div class="divider">

<span>OR</span>

</div>

<a href="register.php" class="register-btn">

<i class="fa-solid fa-user-plus"></i>

Create New Account

</a>

</form>

</div>

</div>

</div>

</section>

<?php include "includes/layout/footer.php"; ?>

<script>

function togglePassword(){

const password=document.getElementById("password");

const icon=document.querySelector(".toggle-password");

if(password.type==="password"){

password.type="text";

icon.classList.remove("fa-eye");

icon.classList.add("fa-eye-slash");

}else{

password.type="password";

icon.classList.remove("fa-eye-slash");

icon.classList.add("fa-eye");

}

}

</script>

</body>

</html>