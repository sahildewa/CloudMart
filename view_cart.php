<?php
session_start();
include "config/config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT
cart.id,
cart.quantity,
products.product_name,
products.price,
products.image_url
FROM cart
JOIN products
ON cart.product_id = products.id
WHERE cart.user_id = '$user_id'";

$result = mysqli_query($conn,$sql);

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container">

<h1>My Cart</h1>

<table class="table">

<tr>
<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
</tr>

<?php

$grandTotal = 0;

while($row=mysqli_fetch_assoc($result))
{

$total = $row['price'] * $row['quantity'];

$grandTotal += $total;

?>

<tr>

<td>
<img src="<?php echo $row['image_url']; ?>" width="80">
</td>

<td><?php echo htmlspecialchars($row['product_name']); ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td><?php echo $row['quantity']; ?></td>

<td>₹<?php echo $total; ?></td>

</tr>

<?php } ?>

</table>

<h2>Grand Total : ₹<?php echo $grandTotal; ?></h2>

<br>

<a href="checkout.php">

<button>

Proceed to Checkout

</button>

</a>

</div>

<?php include "includes/footer.php"; ?>