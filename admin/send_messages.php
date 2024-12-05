<?php
include '../config/connect.php';
session_start();
ob_start();

// Check if the required data is posted
if (isset($_POST['message']) && isset($_POST['receiver_id']) && isset($_POST['sender_id'])) {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Insert the message into the database
    $query = "INSERT INTO messages (sender_id, receiver_id, content, timestamp) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $sender_id, $receiver_id, $message);
    if ($stmt->execute()) {
        // Send a response back to the client (could include additional data like the message ID)
        echo json_encode(['status' => 'success', 'message' => $message, 'sender_id' => $sender_id, 'receiver_id' => $receiver_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send the message']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
