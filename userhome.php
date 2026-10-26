<?php
session_start();
if (!isset($_SESSION["ssno"])) { header("Location:http://localhost:81/kartify/login.php"); exit; }

$conn = new mysqli("localhost", "root", "", "kartify");
$user_id = $_SESSION["ssno"];
$is_admin = $_SESSION["is_admin"];

$search = $_GET['search'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

$query = "SELECT * FROM products WHERE 1=1";
if ($search) { $query .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')"; }
if ($min_price) { $query .= " AND price >= $min_price"; }
if ($max_price) { $query .= " AND price <= $max_price"; }
$products = $conn->query($query);

$cart_count = $conn->query("SELECT SUM(quantity) as total FROM cart WHERE user_id = $user_id")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kartify Store</title>
    <link rel="stylesheet" href="http://localhost:81/kartify/style.css">
</head>
<body>
    <header id="header">
        <table width="100%">
            <tr>
                <td><img src="http://localhost:81/kartify/Logo.png" alt="Kartify"></td>
                <td>
                    <nav>
                        <a href="http://localhost:81/kartify/cart.php">Cart (<?= $cart_count ?>)</a>
                        <a href="http://localhost:81/kartify/profile.php">Profile</a>
                        <?php if($is_admin): ?> <a href="http://localhost:81/kartify/admin.php" class="admin-link">Admin Panel</a> <?php endif; ?>
                        <a href="http://localhost:81/kartify/logout.php">Logout</a>
                    </nav>
                </td>
            </tr>
        </table>
    </header>

    <main id="content">
        <h1>Welcome, <?= htmlspecialchars($_SESSION["ssname"]) ?>!</h1>
        <form method="GET" class="search-bar">
            <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
            <input type="number" name="min_price" placeholder="Min ₹" value="<?= htmlspecialchars($min_price) ?>">
            <input type="number" name="max_price" placeholder="Max ₹" value="<?= htmlspecialchars($max_price) ?>">
            <button type="submit">Search</button>
            <a href="http://localhost:81/kartify/userhome.php" style="padding: 10px; color: #2874f0; font-weight:bold;">Clear</a>
        </form>

        <div class="grid">
            <?php while($row = $products->fetch_assoc()): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Product">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p class="price">₹<?= number_format($row['price'], 2) ?></p>
                    <form action="http://localhost:81/kartify/add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <footer id="footer"><p>@Kartify 2025</p></footer>
</body>
</html>