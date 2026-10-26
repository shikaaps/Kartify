<?php
session_start();
if (!isset($_SESSION["ssno"])) { header("Location:login.php"); exit; }
$conn = new mysqli("localhost", "root", "", "kartify");
$user = $_SESSION["ssno"];

if(isset($_GET['remove'])) {
    $id = $_GET['remove'];
    $conn->query("DELETE FROM cart WHERE id=$id AND user_id=$user");
    header("Location:cart.php"); exit;
}

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
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header id="header">
        <table width="100%">
            <tr>
                <td><a href="userhome.php" style="color:white;">&larr; Back to Shop</a></td>
                <td style="text-align:right;"><a href="logout.php" style="color:white;">Logout</a></td>
            </tr>
        </table>
    </header>
    <main id="content">
        <h1>Your Cart</h1>
        <table class="data-table">
            <tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th><th>Action</th></tr>
            <?php while($row = $items->fetch_assoc()): 
                $sub = $row['price'] * $row['quantity'];
                $total += $sub;
            ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>₹<?= number_format($row['price'], 2) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>₹<?= number_format($sub, 2) ?></td>
                <td><a href="cart.php?remove=<?= $row['id'] ?>" class="btn-danger">Remove</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <h2 style="text-align:right; margin-top:20px;">Grand Total: ₹<?= number_format($total, 2) ?></h2>
        <form method="POST" style="text-align:right; background:transparent; padding:0; box-shadow:none;">
            <input type="hidden" name="total" value="<?= $total ?>">
            <button type="submit" name="checkout" class="checkout-btn">Place Order</button>
        </form>
    </main>
</body>
</html>