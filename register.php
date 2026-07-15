<?php
session_start();
include "config/config.php";

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check)>0)
    {
        $message = "Email already exists!";
    }
    else
    {
        mysqli_query($conn,"INSERT INTO users(username,email,password)
        VALUES('$username','$email','$password')");

        header("Location: login.php");
        exit();
    }
}
?>

<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<h2>Register</h2>

<form method="POST">

    <input type="text" name="username" placeholder="Username" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>

    <button name="register">Register</button>

</form>

<?php
if(isset($message))
{
    echo "<p>$message</p>";
}
?>

<?php include "includes/footer.php"; ?>