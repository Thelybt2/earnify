<?php
// Database connection
$host = "localhost";
$dbname = "earnify";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $referralCode = bin2hex(random_bytes(4)); // Generate a unique referral code
    $referredBy = $_POST['referredBy'] ?? null; // Optional referral code

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered."]);
        exit;
    }

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, referral_code, referred_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $password, $referralCode, $referredBy);

    if ($stmt->execute()) {
        // Update referral count for referrer
        if ($referredBy) {
            $updateReferrer = $conn->prepare("UPDATE users SET referrals_count = referrals_count + 1 WHERE referral_code = ?");
            $updateReferrer->bind_param("s", $referredBy);
            $updateReferrer->execute();
        }

        echo json_encode(["status" => "success", "message" => "Registration successful!", "referralCode" => $referralCode]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to register."]);
    }
}

