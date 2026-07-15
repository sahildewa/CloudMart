<?php
session_start();
include "../config/config.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM users ORDER BY id DESC");

include "includes/header.php";
include "includes/sidebar.php";
?>

<div class="main-content">

<h1>Users</h1>

<table class="table">

<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
    <th>Joined</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['username']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo ucfirst($row['role']); ?></td>

<td>
<?php
echo isset($row['created_at']) ? $row['created_at'] : "-";
?>
</td>

</tr>

<?php } ?>

</table>

</div>

<?php include "includes/footer.php"; ?>