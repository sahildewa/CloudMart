<?php

$host = "YOUR-RDS-ENDPOINT";
$user = "sahil";
$pass = "YOUR_PASSWORD";
$dbname = "cloudmart_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
