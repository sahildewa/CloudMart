<?php
session_start();

include "../config/config.php";
require "../vendor/autoload.php";

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Check Admin Login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

// Create S3 Client
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

$bucket = "cloudmart-product-sahil";

if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    // Get product image URL
    $result = mysqli_query($conn, "SELECT image_url FROM products WHERE id = $id");

    if ($product = mysqli_fetch_assoc($result)) {

        $imageUrl = $product['image_url'];

        // Delete image only if it is stored in S3
        if (!empty($imageUrl) && strpos($imageUrl, "amazonaws.com") !== false) {

            $path = parse_url($imageUrl, PHP_URL_PATH);
            $key = ltrim($path, "/");

            try {
                $s3->deleteObject([
                    'Bucket' => $bucket,
                    'Key'    => $key
                ]);
            } catch (AwsException $e) {
                // Ignore S3 delete errors
            }
        }

        // Delete product from database
        mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    }
}

header("Location: products.php");
exit();
