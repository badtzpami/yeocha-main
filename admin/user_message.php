<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session
$id = $_SESSION["user_id_admin"];
$user_role = 'Admin';

$sessionId = $id;

$valid_user = "SELECT * FROM users WHERE user_id = '" . $sessionId . "' && role != '" . $user_role . "'";
$check_user = mysqli_query($conn, $valid_user);

if (!isset($sessionId) || mysqli_num_rows($check_user) < 0) {
  header("Location: ../index.php");
  session_destroy();
} else {
  $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id = $sessionId"));
}


?>

<?php include "../include/user_meta.php"; ?>
<?php include "../include/user_top.php"; ?>
<style>
  .highlighted {
    background-color: #F3F6F9 !important;
    border-radius: 7px !important;
  }
</style>
<?php include "../include/user_header.php"; ?>


<?php include "../include/sidebar_admin.php"; ?>

<main id="main" class="main">
  <form id="addMessage" method="post">
    <div class="message-container-fluid">
      <div class="message-container">
        <div class="message-sidebar">
          <div class="message-aside">
            <?php
            $user_list_query = "SELECT * FROM users WHERE user_id != '$sessionId' AND status = 'ACTIVE' ORDER BY user_id DESC";
            $user_list_result = mysqli_query($conn, $user_list_query);

            // Fetch the maximum user (the first row in the result)
            $max_user = mysqli_fetch_assoc($user_list_result);

            // Reset the pointer to the start to display the list
            mysqli_data_seek($user_list_result, 0);
            ?>

            <?php if (mysqli_num_rows($user_list_result) > 0) { ?>
              <?php while ($row = mysqli_fetch_array($user_list_result)) { ?>
                <div class="message-aside-item <?php if ($row['user_id'] == $max_user['user_id']) {
                                                  echo 'highlighted';
                                                } ?>"
                  id="user-<?php echo $row['user_id']; ?>"
                  onclick="setReceiverId(<?php echo $row['user_id']; ?>)">
                  <div class="message-link">
                    <div class="symbol">
                      <span class="symbol-label mr-4">
                        <?php if (empty($row['image'])) { ?>
                          <img class="img-fluid img-circle" src="../assets/images/default_images/profile_picture.jpeg" width="35" height="35" title="Profile Picture">
                        <?php } else { ?>
                          <img class="img-fluid img-circle" src="../assets/images/user_images/<?php echo htmlspecialchars($row['image']); ?>" width="35" height="35" title="<?php echo htmlspecialchars($row['firstname']); ?>">
                        <?php } ?>
                      </span>
                      <span class="aside-text">
                        <strong><?= htmlspecialchars($row['firstname'] . " " . $row['lastname']); ?></strong>
                        <div class="text-status"><?= htmlspecialchars($row['role']); ?></div>
                      </span>
                    </div>
                  </div>
                </div>
              <?php } ?>
            <?php } else { ?>
              <p class="no-users">No active users found.</p>
            <?php } ?>

          </div>
        </div>

        <div class="message-main-container">
          <div class="message-card-header">
            <div class="message-header-title">Chat</div>
          </div>
          <div class="message-card-body">
            <div class="chat-messages" id="chat-messages">

              <?php
              // Ensure receiver_id is passed and sanitized
              if (isset($_POST['receiver_id'])) {
                echo $receiver = mysqli_real_escape_string($conn, $_POST['receiver_id']);
              }

              $measage_list_query = "SELECT * FROM `messages` WHERE sender_id = $sessionId OR sender_id = $receiver";
              $measage_list_result = mysqli_query($conn, $measage_list_query);
              $counter = 1; // Initialize counter 

              if (mysqli_num_rows($measage_list_result) > 0) {
                while ($measage = mysqli_fetch_array($measage_list_result)) {
                  if ($measage['sender_id'] == $sessionId) {
                    echo '<div class="message-bubble sender">';
                    echo '<p>' . htmlspecialchars($measage['content']) . '</p>';
                    echo '<small>' . date('Y-m-d H:i:s', strtotime($measage['timestamp'])) . '</small>';
                    echo '</div>';
                  } else {
                    echo '<div class="message-bubble receiver">';
                    echo '<p>' . htmlspecialchars($measage['content']) . '</p>';
                    echo '<small>' . date('Y-m-d H:i:s', strtotime($measage['timestamp'])) . '</small>';
                    echo '</div>';
                  }
                }
              } else {
                echo '<p>No messages found.</p>';
              }
              ?>

            </div>
          </div>

          <div class="message-card-footer">
            <div class="div">
              <?php
              // Determine the sender's ID based on session data
              if ($_SESSION["user_id_admin"] != '') {
                $id = $_SESSION["user_id_admin"];
              } else if ($_SESSION["user_id_cashier"] != '') {
                $id = $_SESSION["user_id_cashier"];
              } else if ($_SESSION["user_id_employee"] != '') {
                $id = $_SESSION["user_id_employee"];
              } else {
                $id = $_SESSION["user_id_supplier"];
              }
              ?>
              <input type="text" name="receiver_id" id="receiver_id" value="<?php echo $max_user['user_id']; ?>" readonly />
              <input type="text" name="sender_id" id="sender_id" value="<?php echo $id; ?>" readonly />
              <textarea id="message-input" name="message-input" placeholder="Enter message here" class="form-control" rows="1"></textarea>
              <button type="submit" id="send-button" class="physical_inventory_button">
                Send
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>


<?php include "../include/user_footer.php"; ?>
<?php include "../include/user_bottom.php"; ?>

<script>
  // Listen for the 'input' event on the textarea
  document.getElementById('message-input').addEventListener('input', function() {
    // Get the value of the textarea
    const messageInputValue = this.value;

    // Set the value of the input field with id="message" to be the same as the textarea
    document.getElementById('message').value = messageInputValue;
  });
</script>

<script>
  // Wait until the DOM is fully loaded
  document.addEventListener('DOMContentLoaded', function() {

    // Add click event listener for the send button
    document.getElementById('send-button').addEventListener('click', function() {
      const messageInput = document.getElementById('message-input');
      const chatMessages = document.getElementById('chat-messages');
      const noMessages = document.getElementById('no-messages');
      const messageContent = messageInput.value.trim();
      const receiverId = document.getElementById('receiver_id').value;
      const senderId = document.getElementById('sender_id').value;

      // Ensure the message content is not empty
      if (messageContent) {
        // Create a new message bubble (sender)
        const messageBubble = document.createElement('div');
        messageBubble.classList.add('message-bubble', 'sender'); // Add 'sender' class for current user
        messageBubble.innerHTML = `
        <div class="message-bubble sender">
          <p>${messageContent}</p>
        </div><br>
          <small>${new Date().toLocaleString()}</small>
      `;

        // Append the new message to the chat window
        chatMessages.appendChild(messageBubble);

        // If the "No messages found" message exists, hide it
        if (noMessages) {
          noMessages.style.display = 'none'; // Hide the "No messages" message
        }

        // Clear the input field and focus it again for the next message
        messageInput.value = '';
        messageInput.focus();

        // Scroll to the bottom of the chat window to show the new message
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Submit the message to the server via AJAX
        const formData = new FormData();
        formData.append('message', messageContent);
        formData.append('sender_id', senderId);
        formData.append('receiver_id', receiverId);

        // Make the AJAX request to submit the message to the server
        fetch('send_messages.php', {
            method: 'POST',
            body: formData,
          })
          .then(response => response.json())
          .then(data => {
            console.log(data); // Log the response from the server (e.g., the message ID or status)
            // You can further process the response if needed
          })
          .catch(error => console.error('Error:', error));
      }
    });

  });
</script>