<?php
// Include the database configuration
require 'db_config.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON input from the client
    $data = json_decode(file_get_contents("php://input"));

    // Validate the incoming data
    if (!isset($data->username) || !isset($data->email) || !isset($data->password)) {
        echo json_encode(["success" => false, "message" => "All fields are required!"]);
        exit;
    }

    $username = $data->username;
    $email = $data->email;
    $password = $data->password;

    // Validate input fields
    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "All fields are required!"]);
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute the query and return a response
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registration successful!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>

