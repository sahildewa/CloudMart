<?php

session_start();
include "../config/config.php";

if($_SERVER["REQUEST_METHOD"]=="POST")
{

$name=trim($_POST['category']);

mysqli_query($conn,"INSERT INTO categories(category_name)
VALUES('$name')");

header("Location: categories.php");
exit();

}

include "includes/header.php";
include "includes/sidebar.php";

?>

<div class="main-content">

<h2>Add Category</h2>

<form method="POST">

<input
type="text"
name="category"
placeholder="Category Name"
required>

<br><br>

<button>Add Category</button>

</form>

</div>

<?php include "includes/footer.php"; ?>