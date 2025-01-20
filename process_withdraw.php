<?php
include 'db_config.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = 12345; // Replace with the actual user ID from your session or app logic
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    $details = $_POST['details'];

    // Validate the inputs (optional but recommended)
    if ($amount < 25) {
        die("Error: Minimum withdrawal amount is $25.");
    }
    if (empty($method) || empty($details)) {
        die("Error: Please fill out all fields.");
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO withdrawals (user_id, amount, method, details) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("idss", $user_id, $amount, $method, $details);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Withdrawal request submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
