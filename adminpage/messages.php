<?php
include('../adminpage/header.php');
require '../userLogin/db_con.php';

if (!isset($_SESSION['admin_id']) && !isset($_SESSION['staff_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_sess_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] :
                   (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 
                   (isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : null));

?>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
            <h3 class="card-title">Staff</h3>
            <h4 id="chatWith" class="ml-auto" style="font-weight: bold;">Select a User</h4>
          </div>

          <div class="card-body">
            <div class="row">
              <!-- Inbox Section -->
              <div class="col-md-4" style="border-right: 1px solid #ddd;">
                <h5>Inboxes</h5>
                <!-- Search Box -->
                <div class="mb-3">
                  <input type="text" id="searchBox" class="form-control" placeholder="Search inboxes">
                  <ul id="searchResults" class="list-group mt-2"></ul>
                </div>
              </div>

              <!-- Chatting Area -->
              <div class="col-md-8">
                <h5>Chat Area</h5>
                <div id="chatWindow" class="chat-window" style="height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; background: #f9f9f9;">
                  <!-- Chat messages will appear here -->
                </div>
                <form id="messageForm" style="margin-top: 10px;">
                  <div class="input-group">
                    <input type="text" id="messageInput" class="form-control" placeholder="Type a message">
                    <input type="text" id="receiverId">
                    <input type="text" id="senderID" value="<?php echo $current_sess_id; ?>" />
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Get the current session ID from the hidden input field
  const currentSessId = document.getElementById('senderID').value;
  const searchBox = document.getElementById('searchBox');
  const searchResults = document.getElementById('searchResults');
  const chatWith = document.getElementById('chatWith');
  const receiverIdInput = document.getElementById('receiverId');
  const chatWindow = document.getElementById('chatWindow');
  const messageForm = document.getElementById('messageForm');
  const messageInput = document.getElementById('messageInput');

  // Search users dynamically
  searchBox.addEventListener('input', function () {
    const query = this.value;

    if (query.length > 0) {
      fetch(`../realtimechat/search_users.php?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
          searchResults.innerHTML = '';

          if (data.length > 0) {
            data.forEach(user => {
              const li = document.createElement('li');
              li.textContent = user.name;
              li.className = 'list-group-item';
              li.style.cursor = 'pointer';
              li.addEventListener('click', () => {
                selectUser(user);
              });
              searchResults.appendChild(li);
            });
          } else {
            searchResults.innerHTML = '<li class="list-group-item">No results found</li>';
          }
        })
        .catch(error => console.error('Error:', error));
    } else {
      searchResults.innerHTML = '';
    }
  });

  // Select a user to chat with and fetch the conversation
  function selectUser(user) {
    chatWith.textContent = `Chatting with: ${user.name}`;
    receiverIdInput.value = user.id; // Store the receiver's ID
    searchResults.innerHTML = '';
    searchBox.value = '';

    // Fetch messages between the current user and selected user
    fetchMessages(user.id);
  }

  // Fetch messages between the current user and selected user
  function fetchMessages(receiverId) {
  console.log('Fetching messages for Receiver ID:', receiverId);

  fetch(`../realtimechat/fetch_messages.php?sender_id=${currentSessId}&receiver_id=${receiverId}`)
    .then(response => response.json())
    .then(data => {
      chatWindow.innerHTML = ''; // Clear previous messages
      console.log('Fetched messages:', data); // Log response
      if (data.length > 0) {
        data.forEach(message => {
          const messageElement = document.createElement('div');
          messageElement.innerHTML = `<strong>${message.sender_name}:</strong> ${message.message}`;
          messageElement.className = 'message';
          chatWindow.appendChild(messageElement);
        });
      } else {
        chatWindow.innerHTML = '<p>No messages found.</p>';
      }
      chatWindow.scrollTop = chatWindow.scrollHeight; // Scroll to latest message
    })
    .catch(error => console.error('Error fetching messages:', error));
}

  // Send a message
  messageForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const message = messageInput.value;
    const receiverId = receiverIdInput.value;

    if (message && receiverId) {
      fetch('../realtimechat/send_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
          message,
          receiver_id: receiverId,
          sender_id: currentSessId // Pass the session ID as sender_id
        })
      })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            // Append the new message to the chat window
            const messageElement = document.createElement('div');
            messageElement.innerHTML = `<strong>You:</strong> ${message}`;
            messageElement.className = 'message';
            chatWindow.appendChild(messageElement);

            // Scroll to the latest message
            chatWindow.scrollTop = chatWindow.scrollHeight;

            // Clear the message input
            messageInput.value = '';
          } else {
            alert(data.message || 'Failed to send message.');
          }
        })
        .catch(error => console.error('Error:', error));
    } else {
      alert('Please select a user and enter a message.');
    }
  });
</script>








  </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);

            sessionStorage.removeItem('successMessage');
        }
    });
</script>


<?php
include('../adminpage/footer.php');
?>