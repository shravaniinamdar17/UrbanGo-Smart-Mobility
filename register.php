<?php
session_start();

require_once "config/db_connect.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $gender   = $_POST['gender'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if (
        empty($fullname) ||
        empty($username) ||
        empty($email) ||
        empty($phone) ||
        empty($gender) ||
        empty($password) ||
        empty($confirm)
    ) {

        $error = "Please fill all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Invalid email address.";

    } elseif ($password != $confirm) {

        $error = "Passwords do not match.";

    } elseif (strlen($password) < 8) {

        $error = "Password must contain at least 8 characters.";

    } else {

        $check = mysqli_prepare(
            $conn,
            "SELECT id FROM users WHERE email=? OR username=?"
        );

        mysqli_stmt_bind_param($check, "ss", $email, $username);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {

            $error = "Email or Username already exists.";

        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert = mysqli_prepare(
                $conn,
                "INSERT INTO users
                (full_name, username, email, phone, gender, password)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $insert,
                "ssssss",
                $fullname,
                $username,
                $email,
                $phone,
                $gender,
                $hashedPassword
            );

            if (mysqli_stmt_execute($insert)) {

                $success = "Registration Successful! Please Login.";

            } else {

                $error = "Registration Failed.";

            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Create Account | UrbanGo</title>

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/register.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include "includes/layout/navbar.php"; ?>

<section class="register-page">

<div class="register-container">

<div class="register-left">

<h1>Create Your UrbanGo Account</h1>

<p>

Book buses, trains, metro, cabs and EV charging stations across India.

</p>

<img src="assets/images/hero-bus.png" alt="UrbanGo">

</div>

<div class="register-right">

<div class="register-card">

<h2>Create Account</h2>

<p>Join UrbanGo Smart Mobility</p>

<?php if($success!=""){ ?>

<div class="success-box">

<i class="fa-solid fa-circle-check"></i>

<?php echo $success; ?>

</div>

<?php } ?>

<?php if($error!=""){ ?>

<div class="error-box">

<i class="fa-solid fa-circle-xmark"></i>

<?php echo $error; ?>

</div>

<?php } ?>

<form method="POST">

<div class="form-group">

<label>

<i class="fa-solid fa-user"></i>

Full Name

</label>

<input
type="text"
name="fullname"
placeholder="Enter Full Name"
required>

</div>

<div class="form-group">

<label>

<i class="fa-solid fa-id-card"></i>

Username

</label>

<input
type="text"
name="username"
placeholder="Choose Username"
required>

</div>

<div class="form-group">

<label>

<i class="fa-solid fa-envelope"></i>

Email Address

</label>

<input
type="email"
name="email"
placeholder="Enter Email"
required>

</div>

<div class="form-group">

<label>

<i class="fa-solid fa-phone"></i>

Phone Number

</label>

<input
type="text"
name="phone"
placeholder="10 Digit Mobile Number"
required>

</div>

<div class="form-group">

<label>

<i class="fa-solid fa-venus-mars"></i>

Gender

</label>

<select name="gender" required>

<option value="">Select Gender</option>

<option>Female</option>

<option>Male</option>

<option>Other</option>

</select>

</div>
<div class="form-group">

<label>

<i class="fa-solid fa-lock"></i>

Password

</label>

<div class="password-box">

<input
type="password"
name="password"
id="password"
placeholder="Create Password"
required>

<i
class="fa-solid fa-eye toggle-password"
onclick="togglePassword('password',this)">
</i>

</div>

<div class="strength">

<div id="strengthBar"></div>

</div>

<small id="strengthText">

Minimum 8 characters

</small>

</div>

<div class="form-group">

<label>

<i class="fa-solid fa-lock"></i>

Confirm Password

</label>

<div class="password-box">

<input
type="password"
name="confirm_password"
id="confirm_password"
placeholder="Confirm Password"
required>

<i
class="fa-solid fa-eye toggle-password"
onclick="togglePassword('confirm_password',this)">
</i>

</div>

</div>

<div class="terms">

<label>

<input type="checkbox" required>

I agree to the

<a href="#">Terms & Conditions</a>

and

<a href="#">Privacy Policy</a>

</label>

</div>

<button
type="submit"
class="register-btn">

<i class="fa-solid fa-user-plus"></i>

Create Account

</button>

<div class="login-link">

Already have an account?

<a href="login.php">

Login Here

</a>

</div>

</form>

</div>

</div>

</div>

</section>

<?php include "includes/layout/footer.php"; ?>

<script>

function togglePassword(id,icon){

const input=document.getElementById(id);

if(input.type==="password"){

input.type="text";

icon.classList.remove("fa-eye");

icon.classList.add("fa-eye-slash");

}else{

input.type="password";

icon.classList.remove("fa-eye-slash");

icon.classList.add("fa-eye");

}

}

const password=document.getElementById("password");

const bar=document.getElementById("strengthBar");

const text=document.getElementById("strengthText");

password.addEventListener("keyup",function(){

let val=password.value;

let score=0;

if(val.length>=8) score++;

if(/[A-Z]/.test(val)) score++;

if(/[0-9]/.test(val)) score++;

if(/[^A-Za-z0-9]/.test(val)) score++;

if(score==1){

bar.style.width="25%";
bar.style.background="#ff4d4d";
text.innerHTML="Weak Password";

}

else if(score==2){

bar.style.width="50%";
bar.style.background="#ff9800";
text.innerHTML="Medium Password";

}

else if(score==3){

bar.style.width="75%";
bar.style.background="#2196f3";
text.innerHTML="Good Password";

}

else if(score>=4){

bar.style.width="100%";
bar.style.background="#00c853";
text.innerHTML="Strong Password";

}

});

</script>

</body>

</html>