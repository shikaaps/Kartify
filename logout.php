<?php
session_start();
session_destroy();
header("Location:http://localhost:81/kartify/login.php");
exit;
?>