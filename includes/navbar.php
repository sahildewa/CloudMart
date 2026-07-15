<nav>

<a class="logo" href="index.php">
CloudMart
</a>

<div class="links">

<a href="index.php">Home</a>

<a href="view_cart.php">Cart</a>

<?php if(isset($_SESSION['user_id'])){ ?>

<a href="my_orders.php">My Orders</a>

<a href="logout.php">Logout</a>

<?php } else { ?>

<a href="login.php">Login</a>

<a href="register.php">Register</a>

<?php } ?>

</div>

</nav>