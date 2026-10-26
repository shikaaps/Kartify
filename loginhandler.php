<?php
session_start();
$conn = new mysqli("localhost", "root", "", "kartify");
if ($conn->connect_error) die("Connection failed");

$u = isset($_GET['n']) ? trim($_GET['n']) : '';
$p = isset($_GET['p']) ? $_GET['p'] : '';

if ($u === '' || $p === '') {
    header("Location:login.php?msg=" . urlencode("Please fill in all fields."));
    exit;
}

$stmt = $conn->prepare("SELECT id, name, username, password, is_admin FROM users WHERE username = ?");
$stmt->bind_param("s", $u);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

if ($row && password_verify($p, $row['password'])) {
    $_SESSION["ssno"]   = $row["id"];
    $_SESSION["ssname"] = $row["name"];
    $_SESSION["ssuser"] = $row["username"];
    $_SESSION["is_admin"] = $row["is_admin"];
    header("Location:userhome.php");
    exit;
} else {
    header("Location:login.php?msg=" . urlencode("invalid credentials"));
    exit;
}
?>