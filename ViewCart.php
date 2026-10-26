<?php
session_start();
$conn = new mysqli("localhost", "root", "", "kartify");
$user = $_SESSION["ssno"];

// Handle Remove
if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    $conn->query("DELETE FROM cart WHERE id=$id AND user_id=$user");
    header("Location:cart.php"); exit;
}

// Handle Checkout
if(isset($_POST['checkout'])) {
    $total = $_POST['total'];
    $conn->query("INSERT INTO orders (user_id, total_amount) VALUES ($user, $total)");
    $conn->query("DELETE FROM cart WHERE user_id=$user");
    echo "<script>alert('Order Placed Successfully!'); window.location.href='userhome.php';</script>";
}

$items = $conn->query("SELECT c.id, p.name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id=$user");
$total = 0;
?>
<!DOCTYPE html>
<html>
<head><title>Your Cart</title><link rel="stylesheet" href="style.css"></head>
<body>
    <header id="header"><table width="100%"><tr><td><a href="userhome.php" style="color:white;">&larr; Back to Shop</a></td><td style="text-align:right;"><a href="logout.php" style="color:white;">Logout</a></td></tr></table></header>
    <main id="content">
        <h1>Your Cart</h1>
        <table border="1" style="width:100%; text-align:center; border-collapse: collapse; background:white;">
            <tr style="background:#2874f0; color:white;"><th>Product</th><th>Price</th><th>Qty</th><th>Total</th><th>Action</th></tr>
            <?php while($row = $items->fetch_assoc()): 
                $sub = $row['price'] * $row['quantity'];
                $total += $sub;
            ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td>₹<?= $row['price'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>₹<?= $sub ?></td>
                <td><a href="cart.php?remove=<?= $row['id'] ?>" style="color:red;">Remove</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <h2 style="text-align:right; margin-top:20px;">Grand Total: ₹<?= $total ?></h2>
        <form method="POST" style="text-align:right;">
            <input type="hidden" name="total" value="<?= $total ?>">
            <button type="submit" name="checkout" style="background:#fb641b; color:white; padding:12px 30px; border:none; border-radius:5px; cursor:pointer; font-size:1.1rem;">Place Order</button>
        </form>
    </main>
</body>
</html>