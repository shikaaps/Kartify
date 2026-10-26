<?php
session_start();
if (!isset($_SESSION["ssno"]) || $_SESSION["is_admin"] != 1) { header("Location:http://localhost:81/kartify/userhome.php"); exit; }
$conn = new mysqli("localhost", "root", "", "kartify");

if(isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $conn->query("INSERT INTO products (name, description, price, image_url) VALUES ('$name', '$desc', $price, '$img')");
}

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location:http://localhost:81/kartify/admin.php"); exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="http://localhost:81/kartify/style.css">
</head>
<body>
    <header id="header">
        <table width="100%">
            <tr>
                <td><a href="http://localhost:81/kartify/userhome.php" style="color:white;">&larr; Back to Shop</a></td>
                <td style="text-align:right; color:yellow; font-weight:bold;">ADMIN MODE</td>
            </tr>
        </table>
    </header>
    <main id="content">
        <h1>Manage Products</h1>
        
        <form method="POST">
            <h3>Add New Product</h3>
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="desc" placeholder="Description" required style="height: 80px; margin-top:10px;"></textarea>
            <input type="number" name="price" placeholder="Price" required>
            <input type="text" name="img" placeholder="Image URL (e.g., shoe.jpg)" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>

        <table class="data-table">
            <tr><th>ID</th><th>Name</th><th>Price</th><th>Action</th></tr>
            <?php
            $res = $conn->query("SELECT * FROM products");
            while($row = $res->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>₹{$row['price']}</td>
                    <td><a href='http://localhost:81/kartify/admin.php?delete={$row['id']}' class='btn-danger'>Delete</a></td>
                </tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>