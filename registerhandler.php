<?php
session_start();
$conn = new mysqli("localhost", "root", "", "kartify");
if ($conn->connect_error) die("Connection failed");

$name = trim($_POST['n'] ?? '');
$gender = $_POST['g'] ?? '';
$dob = $_POST['d'] ?? '';
$contact_pref = $_POST['contactPref'] ?? '';
$email = trim($_POST['em'] ?? '');
$phone = trim($_POST['nu'] ?? '');
$username = trim($_POST['u'] ?? '');
$password_raw = $_POST['p'] ?? '';

if ($name === '' || $gender === '' || $dob === '' || $contact_pref === '' || $username === '' || $password_raw === '') {
    header("Location:http://localhost:81/kartify/register.php?msg=" . urlencode("Please fill all fields.")); exit;
}
if ($contact_pref === 'Email') { $phone = null; } else { $email = null; }

$chk = $conn->prepare("SELECT id FROM users WHERE username = ?");
$chk->bind_param("s", $username);
$chk->execute();
if ($chk->get_result()->num_rows > 0) {
    header("Location:http://localhost:81/kartify/register.php?msg=" . urlencode("Username taken.")); exit;
}
$chk->close();

$hashed = password_hash($password_raw, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (name, gender, dob, contact_pref, email, phone, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $name, $gender, $dob, $contact_pref, $email, $phone, $username, $hashed);

if ($stmt->execute()) {
    $stmt->close(); $conn->close();
    header("Location:http://localhost:81/kartify/login.php?msg=" . urlencode("Registration successful! Please log in."));
    exit;
} else {
    $stmt->close(); $conn->close();
    header("Location:http://localhost:81/kartify/register.php?msg=" . urlencode("Registration failed."));
    exit;
}
?>