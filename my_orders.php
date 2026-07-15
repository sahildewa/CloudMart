<?php
session_start();
include "config/config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id=$_SESSION['user_id'];

$result=mysqli_query($conn,"
SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY id DESC
");

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container">

<h1>My Orders</h1>

<table class="table">

<tr>

<th>Order ID</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>

</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td>#<?php echo $row['id']; ?></td>

<td>₹<?php echo $row['total_price']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['created_at']; ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php include "includes/footer.php"; ?>