<?php
session_start();
include "config/config.php";

$result = mysqli_query($conn,"
SELECT
products.*,
categories.category_name
FROM products
JOIN categories
ON products.category_id=categories.id
WHERE status='Active'
ORDER BY products.id DESC
");

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container">

<h1>Latest Products</h1>

<div class="products">

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<div class="product-card">

<img
src="<?php echo $row['image_url']; ?>"
width="220"
height="220">

<h3>

<?php echo htmlspecialchars($row['product_name']); ?>

</h3>

<p>

<?php echo htmlspecialchars($row['category_name']); ?>

</p>

<h2>

₹<?php echo $row['price']; ?>

</h2>

<a href="product.php?id=<?php echo $row['id']; ?>">

View Product

</a>

</div>

<?php } ?>

</div>

</div>

<?php include "includes/footer.php"; ?>