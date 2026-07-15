<?php
session_start();
include "config/config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all cart items
$sql = "SELECT
cart.*,
products.price
FROM cart
JOIN products
ON cart.product_id = products.id
WHERE cart.user_id='$user_id'";

$result = mysqli_query($conn,$sql);

$total = 0;

while($row = mysqli_fetch_assoc($result))
{
    $total += ($row['price'] * $row['quantity']);
}

if($total==0){
    die("Your cart is empty.");
}

if(isset($_POST['place_order']))
{

    // Create Order
    mysqli_query($conn,"
    INSERT INTO orders(user_id,total_price)
    VALUES('$user_id','$total')
    ");

    $order_id = mysqli_insert_id($conn);

    // Read cart again
    $cart = mysqli_query($conn,"
    SELECT
    cart.*,
    products.price
    FROM cart
    JOIN products
    ON cart.product_id=products.id
    WHERE cart.user_id='$user_id'
    ");

    while($item=mysqli_fetch_assoc($cart))
    {

        mysqli_query($conn,"
        INSERT INTO order_items
        (order_id,product_id,quantity,price)
        VALUES
        (
        '$order_id',
        '{$item['product_id']}',
        '{$item['quantity']}',
        '{$item['price']}'
        )
        ");

    }

    // Empty Cart

    mysqli_query($conn,"
    DELETE FROM cart
    WHERE user_id='$user_id'
    ");

    header("Location: my_orders.php");
    exit();
}

include "includes/header.php";
include "includes/navbar.php";
?>

<div class="container">

<h1>Checkout</h1>

<h2>Total : ₹<?php echo $total; ?></h2>

<form method="POST">

<button name="place_order">

Place Order

</button>

</form>

</div>

<?php include "includes/footer.php"; ?>