<?php
session_start();
include 'db_connect.php'; // Replace with your database connection file

// Assume user ID is stored in session after login
$user_id = $_SESSION['user_id'];

// Fetch user referral data
$userQuery = $conn->prepare("SELECT referral_count, referral_link FROM users WHERE id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $referralCount = $userData['referral_count'];
    $referralLink = $userData['referral_link'];
} else {
    die("User not found.");
}

// Use $referralCount and $referralLink as needed
?>
