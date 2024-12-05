<?php
include '../config/connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id_admin'];  // Your session ID
    $receiver_id = $_POST['receiver_id'];   // The receiver's ID
    $message_content = $_POST['message_content']; // The message content

    // Validate input
    if (!empty($message_content) && !empty($receiver_id)) {
        // Insert the message into the database
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, content, timestamp) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iis", $user_id, $receiver_id, $message_content);

        if ($stmt->execute()) {
            // Message inserted successfully
            echo json_encode(['status' => 'success']);
        } else {
            // Failed to insert message
            echo json_encode(['status' => 'error']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
