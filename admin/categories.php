<?php
session_start();
include "../config/config.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

/* ---------- ADD CATEGORY ---------- */

if(isset($_POST['add']))
{
    $category=trim($_POST['category']);

    if($category!="")
    {
        mysqli_query($conn,"
        INSERT INTO categories(category_name)
        VALUES('$category')
        ");

        header("Location: categories.php");
        exit();
    }
}

/* ---------- DELETE ---------- */

if(isset($_GET['delete']))
{

$id=(int)$_GET['delete'];

mysqli_query($conn,"
DELETE FROM categories
WHERE id=$id
");

header("Location: categories.php");
exit();

}

/* ---------- LOAD EDIT DATA ---------- */

$edit=false;

if(isset($_GET['edit']))
{

$id=(int)$_GET['edit'];

$result=mysqli_query($conn,"
SELECT *
FROM categories
WHERE id=$id
");

$editData=mysqli_fetch_assoc($result);

$edit=true;

}

/* ---------- UPDATE ---------- */

if(isset($_POST['update']))
{

$id=(int)$_POST['id'];

$category=trim($_POST['category']);

mysqli_query($conn,"
UPDATE categories
SET category_name='$category'
WHERE id=$id
");

header("Location: categories.php");
exit();

}

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="main-content">

<h1>Categories</h1>

<form method="POST">

<?php if($edit){ ?>

<input
type="hidden"
name="id"
value="<?php echo $editData['id']; ?>">

<input
type="text"
name="category"
value="<?php echo htmlspecialchars($editData['category_name']); ?>"
required>

<button name="update">Update</button>

<a href="categories.php">Cancel</a>

<?php } else { ?>

<input
type="text"
name="category"
placeholder="Category Name"
required>

<button name="add">Add Category</button>

<?php } ?>

</form>

<br><br>

<table class="table">

<tr>

<th>ID</th>

<th>Category</th>

<th>Created</th>

<th>Action</th>

</tr>

<?php

$result=mysqli_query($conn,"
SELECT *
FROM categories
ORDER BY id DESC
");

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['category_name']); ?></td>

<td><?php echo $row['created_at']; ?></td>

<td>

<a href="?edit=<?php echo $row['id']; ?>">Edit</a>

|

<a
href="?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete category?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<?php include "includes/footer.php"; ?>