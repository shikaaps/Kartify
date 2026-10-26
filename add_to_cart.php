<?php
session_start();
if (!isset($_SESSION["ssno"])) { header("Location:http://localhost:81/kartify/login.php"); exit; }
$conn = new mysqli("localhost", "root", "", "kartify");
$user = $_SESSION["ssno"];
$prod = $_POST['product_id'];

$check = $conn->query("SELECT * FROM cart WHERE user_id=$user AND product_id=$prod");
if($check->num_rows > 0) {
    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id=$user AND product_id=$prod");
} else {
    $conn->query("INSERT INTO cart (user_id, product_id) VALUES ($user, $prod)");
}
header("Location:http://localhost:81/kartify/userhome.php");
?>