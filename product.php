<?php
session_start();
include "config/config.php";

if(!isset($_GET['id']))
{
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

$sql = "SELECT
products.*,
categories.category_name
FROM products
JOIN categories
ON products.category_id = categories.id
WHERE products.id = $id";

$result = mysqli_query($conn,$sql);
$product = mysqli_fetch_assoc($result);

if(!$product)
{
    die("Product not found");
}

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container">

<h1><?php echo htmlspecialchars($product['product_name']); ?></h1>

<img
src="<?php echo $product['image_url']; ?>"
width="300">

<h3>Category:
<?php echo htmlspecialchars($product['category_name']); ?>
</h3>

<h2>₹<?php echo $product['price']; ?></h2>

<p>

<?php echo nl2br(htmlspecialchars($product['description'])); ?>

</p>

<form action="cart.php" method="POST">

<input
type="hidden"
name="product_id"
value="<?php echo $product['id']; ?>">

<label>Quantity</label>

<input
type="number"
name="quantity"
value="1"
min="1"
max="<?php echo $product['stock']; ?>">

<br><br>

<button type="submit">

Add to Cart

</button>

</form>

</div>

<?php include "includes/footer.php"; ?>