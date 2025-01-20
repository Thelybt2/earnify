Tracking reffals 
<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'earnify'); // Adjust with your DB credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a referral code is in the URL
if (isset($_GET['ref'])) {
    $referrerId = $_GET['ref'];

    // Logic to process the referral (e.g., when the referred user signs up)
    if (isset($_POST['signup'])) { // Assuming signup is submitted
        $userId = uniqid(); // Generate a new user ID for the referred user
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        // Add the new user to the database
        $stmt = $conn->prepare("INSERT INTO users (user_id, username, password, referred_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $userId, $username, $password, $referrerId);
        if ($stmt->execute()) {
            // Update the referrer's account balance
            $updateReferrer = $conn->prepare("UPDATE users SET balance = balance + 0.20 WHERE user_id = ?");
            $updateReferrer->bind_param("s", $referrerId);
            $updateReferrer->execute();

            echo "Signup successful! Referral credited.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>
