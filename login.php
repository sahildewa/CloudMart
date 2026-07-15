<?php
session_start();
include "config/config.php";

if(isset($_POST['login']))
{

$email=$_POST['email'];
$password=$_POST['password'];

$result=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($result)==1)
{

$user=mysqli_fetch_assoc($result);

if(password_verify($password,$user['password']))
{

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

// Redirect based on role
if ($user['role'] == 'admin') {
    header("Location: admin/dashboard.php");
} else {
    header("Location: index.php");
}

exit();

}
else
{

$message="Incorrect Password";

}

}
else
{

$message="Email Not Found";

}

}
?>

<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<h2>Login</h2>

<form method="POST">

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<button name="login">Login</button>

</form>

<?php

if(isset($message))
{
echo "<p>$message</p>";
}

?>

<?php include "includes/footer.php"; ?>