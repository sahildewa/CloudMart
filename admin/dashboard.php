<?php
session_start();
include "../config/config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit();
}

$productCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM products"));
$categoryCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM categories"));
$userCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));
$orderCount = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM orders"));

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="main-content">

<h1>Dashboard</h1>

<div class="cards">

<div class="card">
<h3>📦 Products</h3>
<h1><?php echo $productCount; ?></h1>
</div>

<div class="card">
<h3>📂 Categories</h3>
<h1><?php echo $categoryCount; ?></h1>
</div>

<div class="card">
<h3>👥 Users</h3>
<h1><?php echo $userCount; ?></h1>
</div>

<div class="card">
<h3>🛒 Orders</h3>
<h1><?php echo $orderCount; ?></h1>
</div>

</div>

</div>

<?php include "includes/footer.php"; ?>