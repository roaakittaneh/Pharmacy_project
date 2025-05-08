<?php
$host = "localhost";
$user = "root";
$pass = "rootroot";  // Replace with your actual password
$db = "pharmacy";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
