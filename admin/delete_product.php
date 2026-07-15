<?php
session_start();
include "../config/config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit();
}

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];

    // Get image path
    $result = mysqli_query($conn,"SELECT image_url FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);

    if($product)
    {
        $image = "../" . $product['image_url'];

        if(file_exists($image))
        {
            unlink($image);
        }

        mysqli_query($conn,"DELETE FROM products WHERE id=$id");
    }
}

header("Location: products.php");
exit();
?>