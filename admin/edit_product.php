<?php
session_start();
include "../config/config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit();
}

$id = (int)$_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if(!$product){
    die("Product not found");
}

if(isset($_POST['update_product']))
{
    $name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category_id'];

    mysqli_query($conn,"
        UPDATE products
        SET
        category_id='$category',
        product_name='$name',
        description='$description',
        price='$price',
        stock='$stock'
        WHERE id=$id
    ");

    header("Location: products.php");
    exit();
}
?>

<?php include "includes/header.php"; ?>
<?php include "includes/sidebar.php"; ?>

<div class="main-content">

    
    <div class="form-card">
    <h2>Edit Product</h2>

<form method="POST">

<label>Product Name</label><br>
<input type="text" name="product_name"
value="<?php echo htmlspecialchars($product['product_name']); ?>" required><br><br>

<label>Category</label><br>

<select name="category_id">

<?php

$categories=mysqli_query($conn,"SELECT * FROM categories ORDER BY category_name");

while($cat=mysqli_fetch_assoc($categories))
{

?>

<option
value="<?php echo $cat['id']; ?>"
<?php if($cat['id']==$product['category_id']) echo "selected"; ?>>

<?php echo htmlspecialchars($cat['category_name']); ?>

</option>

<?php } ?>

</select>

<br><br>

<label>Description</label><br>

<textarea
name="description"
rows="5"
cols="50"><?php echo htmlspecialchars($product['description']); ?></textarea>

<br><br>

<label>Price</label><br>

<input
type="number"
step="0.01"
name="price"
value="<?php echo $product['price']; ?>">

<br><br>

<label>Stock</label><br>

<input
type="number"
name="stock"
value="<?php echo $product['stock']; ?>">

<br><br>

<button name="update_product">

Update Product

</button>

</form>
</div>
</div>

<?php include "includes/footer.php"; ?>