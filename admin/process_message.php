<?php
// Include database connection and start session
include '../config/connect.php';
session_start();

error_reporting(0);

// Check if session is valid
$sessionId = $_SESSION["user_id_admin"];
$user_role = 'Admin';

if (!isset($sessionId)) {
    header("Location: ../signin.php");
    session_destroy();
    exit;
}

// Validate session user
$valid_user = "SELECT * FROM `users` WHERE `user_id` = '" . $sessionId . "' AND `role` = '" . $user_role . "'";
$check_user = mysqli_query($conn, $valid_user);

if (mysqli_num_rows($check_user) < 1) {
    header("Location: ../index.php");
    session_destroy();
    exit;
} else {
    // Fetch user details
    $user = mysqli_fetch_assoc($check_user);
    $sender_id = $user['user_id']; // Use session user's ID as sender
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get message from form
    $message = $conn->real_escape_string($_POST['message']);

    $receiver_id = 2; // Example static receiver ID (replace with your logic)
    $test = $_POST['item_id']; // Example static receiver ID (replace with your logic)

    // Insert message into `messages` table using prepared statements
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters (sender_id: integer, receiver_id: integer, message: string)
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
