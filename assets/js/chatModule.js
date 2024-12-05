document.addEventListener("DOMContentLoaded", function () {
    const chatMessages = document.getElementById("chat-messages");
    const sendButton = document.getElementById("send-button");
    const messageInput = document.getElementById("message-input");
    let selectedReceiverId = null;
  
    // Handle user selection
    document.querySelectorAll(".message-aside-item").forEach((item) => {
        item.addEventListener("click", function () {
            selectedReceiverId = this.getAttribute("data-receiver-id");
  
            if (!selectedReceiverId) {
                chatMessages.innerHTML = "<p>Error: Receiver ID is missing.</p>";
                return;
            }
  
            document.querySelectorAll(".message-aside-item").forEach((el) =>
                el.classList.remove("active-message")
            );
            this.classList.add("active-message");
  
            chatMessages.innerHTML = "<p>Loading messages...</p>";
            loadMessages(selectedReceiverId);
        });
    });
  
    function loadMessages(receiverId) {
        fetch(`user_message.php?receiver_id=${receiverId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    chatMessages.innerHTML = "";
                    data.messages.forEach((message) => {
                        const isReceiver = message.sender_id == receiverId;
                        const messageClass = isReceiver ? "receiver" : "sender";
                        const messageElement = document.createElement("div");
                        messageElement.classList.add("message", messageClass);
                        messageElement.innerHTML = `
                            <p>${message.content}</p>
                            <small>${new Date(message.timestamp).toLocaleString()}</small>
                        `;
                        chatMessages.appendChild(messageElement);
                    });
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                } else {
                    console.error('Error loading messages:', data.message);
                    chatMessages.innerHTML = `<p>Error loading messages: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                chatMessages.innerHTML = "<p>Error loading messages. Please try again later.</p>";
            });
    }
  
    sendButton.addEventListener("click", function () {
        if (!selectedReceiverId) {
            alert("Please select a user to chat with.");
            return;
        }
  
        const content = messageInput.value.trim();
        if (!content) {
            alert("Message cannot be empty!");
            return;
        }
  
        fetch("send_message.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `receiver_id=${selectedReceiverId}&message=${encodeURIComponent(content)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const messageElement = document.createElement("div");
                messageElement.classList.add("message", "sender");
                messageElement.innerHTML = `
                    <p>${content}</p>
                    <small>${new Date().toLocaleString()}</small>
                `;
                chatMessages.appendChild(messageElement);
                messageInput.value = "";
                chatMessages.scrollTop = chatMessages.scrollHeight;
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
            alert("Failed to send the message.");
        });
    });
  });