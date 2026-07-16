<?php
session_start();
include "../config/config.php";

require '../vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$bucket = "cloudmart-product-sahil";

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

if (!isset($conn) && isset($con)) {
    $conn = $con;
}

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['add_product']))
{
    $product_name = $_POST['product_name'];
    $category_id  = $_POST['category_id'];
    $description  = $_POST['description'];
    $price        = $_POST['price'];
    $stock        = $_POST['stock'];

    $imageName = time() . "_" . basename($_FILES['image']['name']);

    try {

        $result = $s3->putObject([
            'Bucket'     => $bucket,
            'Key'        => "products/" . $imageName,
            'SourceFile' => $_FILES['image']['tmp_name']
        ]);

        $imagePath = $result['ObjectURL'];

        $sql = "INSERT INTO products
        (category_id, product_name, description, price, stock, image_url)
        VALUES
        ('$category_id','$product_name','$description','$price','$stock','$imagePath')";

        if(mysqli_query($conn,$sql))
        {
            echo "<script>alert('Product Added Successfully');</script>";
        }
        else
        {
            echo mysqli_error($conn);
        }

    }
    catch (AwsException $e)
    {
        echo $e->getMessage();
    }
}

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="main-content">

<h1>Products</h1>

<div class="form-card">

<form method="POST" action="" enctype="multipart/form-data">

<label>Product Name</label><br>
<input type="text" name="product_name" required><br><br>

<label>Category</label><br>

<select name="category_id" required>

<option value="">Select Category</option>

<?php

$result=mysqli_query($conn,"SELECT * FROM categories ORDER BY category_name");

while($row=mysqli_fetch_assoc($result))
{

?>

<option value="<?php echo $row['id']; ?>">

<?php echo htmlspecialchars($row['category_name']); ?>

</option>

<?php
}
?>

</select>

<br><br>

<label>Description</label><br>

<textarea
name="description"
rows="5"
cols="50"
required></textarea>

<br><br>

<label>Price</label><br>

<input
type="number"
step="0.01"
name="price"
required>

<br><br>

<label>Stock</label><br>

<input
type="number"
name="stock"
required>

<br><br>

<label>Product Image</label><br>

<input
type="file"
name="image"
accept="image/*"
required>

<br><br>

<button type="submit" name="add_product">

Add Product

</button>

</form>

</div>

</div>

<h2>All Products</h2>

<table class="table">

<tr>
    <th>Image</th>
    <th>Product</th>
    <th>Category</th>
    <th>Price</th>
    <th>Stock</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php

$sql = "SELECT
products.*,
categories.category_name
FROM products
JOIN categories
ON products.category_id = categories.id
ORDER BY products.id DESC";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<img src="<?php echo $row['image_url']; ?>" width="70">

</td>

<td><?php echo htmlspecialchars($row['product_name']); ?></td>

<td><?php echo htmlspecialchars($row['category_name']); ?></td>

<td>₹<?php echo $row['price']; ?></td>

<td><?php echo $row['stock']; ?></td>

<td><?php echo $row['status']; ?></td>

<td>

<a href="edit_product.php?id=<?php echo $row['id']; ?>">
Edit
</a>
<a href="delete_product.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this product?')">
Delete
</a>

</td>

</tr>

<?php
}
?>

</table>

<?php include "includes/footer.php"; ?>
