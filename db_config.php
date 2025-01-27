<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <p>Your referral code: <strong><?php echo htmlspecialchars($user['referral_code']); ?></strong></p>
    <p>Balance: $<?php echo number_format($user['balance'], 2); ?></p>
    <p>Referrals: <?php echo htmlspecialchars($user['referrals_count']); ?></p>
    <p>Referred By: <?php echo htmlspecialchars($user['referred_by'] ?? 'None'); ?></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
