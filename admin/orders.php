<?php
session_start();
include "../config/config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn,"
SELECT
orders.*,
users.username
FROM orders
LEFT JOIN users
ON orders.user_id=users.id
ORDER BY orders.id DESC
");

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="main-content">

<h1>Orders</h1>

<table class="table">

<tr>

<th>ID</th>

<th>Customer</th>

<th>Total</th>

<th>Status</th>

<th>Date</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['username']); ?></td>

<td>₹<?php echo $row['total_price']; ?></td>
<td><?php echo $row['status']; ?></td>

<td><?php echo $row['created_at']; ?></td>

</tr>

<?php } ?>

</table>

</div>

<?php include "includes/footer.php"; ?>