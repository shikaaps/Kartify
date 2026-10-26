<?php
session_start();
if (!isset($_SESSION["ssno"])) { header("Location:http://localhost:81/kartify/login.php"); exit; }
$conn = new mysqli("localhost", "root", "", "kartify");
$user = $_SESSION["ssno"];

if(isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id=$user");
    $_SESSION["ssname"] = $name;
    echo "<script>alert('Profile Updated!');</script>";
}

$userData = $conn->query("SELECT * FROM users WHERE id=$user")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="http://localhost:81/kartify/style.css">
</head>
<body>
    <header id="header">
        <table width="100%">
            <tr>
                <td><a href="http://localhost:81/kartify/userhome.php" style="color:white;">&larr; Back to Shop</a></td>
                <td style="text-align:right;"><a href="http://localhost:81/kartify/logout.php" style="color:white;">Logout</a></td>
            </tr>
        </table>
    </header>
    <main id="content">
        <form method="POST">
            <h2 style="text-align:center; color:#2874f0; margin-bottom:20px;">My Profile</h2>
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($userData['email'] ?? '') ?>">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($userData['phone'] ?? '') ?>">
            <button type="submit" name="update">Update Profile</button>
        </form>
    </main>
</body>
</html>