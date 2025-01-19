<?php
session_start();

if (!isset($_SESSION['user_country'])) {
    header("Location: login.html"); // Redirect to login if not authenticated
    exit();
}

// Check if the user is accessing their respective country's page
$allowed_country = $_SESSION['user_country'];
$current_country_page = basename($_SERVER['PHP_SELF'], '.php'); // Example: egypt.php

if ($allowed_country !== $current_country_page) {
    echo "Access denied. You are not allowed to access this country's offers.";
    exit();
}
?>
