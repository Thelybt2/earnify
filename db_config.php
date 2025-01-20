<?php
$host = "localhost"; // XAMPP uses localhost
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (empty by default)
$database = "withdrawals_db";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
