<?php
include('../userpage/header.php');
require '../userLogin/db_con.php'; 
include('../userpage/locations.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
$current_sess_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] :
                   (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 
                   (isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : null));

$query = "SELECT * FROM patient_data WHERE user_id = :user_id";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':user_id', $current_sess_id, PDO::PARAM_INT);

$stmt->execute();

$data = $stmt->fetch(PDO::FETCH_ASSOC);

$given_name = $family_name = $middle_name = $suffix = $date_of_birth = '';
$gender = $contact_number = $province = $municipality = $barangay = '';
$email = $postal_code = $heart_disease = $any_accident = $any_surgery = '';
$allergies = $cond_med = $medical_history = '';

if ($data) {
    $given_name = $data['given_name'];
    $family_name = $data['family_name'];
    $middle_name = $data['middle_name'];
    $suffix = $data['suffix'];
    $date_of_birth = $data['date_of_birth'];
    $gender = $data['gender'];
    $contact_number = $data['contact_number'];
    $province = $data['province'];
    $municipality = $data['municipality'];
    $barangay = $data['barangay'];
    $email = $data['email'];
    $postal_code = $data['postal_code'];
    $heart_disease = $data['heart_disease'];
    $any_accident = $data['any_accident'];
    $any_surgery = $data['any_surgery'];
    $allergies = $data['allergies'];
    $cond_med = $data['cond_med'];
    $medical_history = $data['medical_history'];
} else {
    echo "No data found for this user.";
}
?>


<style>
    .message {
        margin-bottom: 10px;
        padding: 8px;
        border-radius: 4px;
    }

    #chatWindow {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    #inputGroup {
        margin-top: 10px;
    }

    .question-item {
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 5px 0;
        cursor: pointer;
    }

    .question-item:hover {
        background-color: #f0f0f0;
    }

    .question-list {
        display: flex;
        justify-content: center; /* Centers the question list */
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 10px;
    }

    .question-item {
        text-align: center; /* Align the question text to the center */
    }

</style>

<main class="main">
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="display: flex; align-items: center; justify-content: space-between;">
                        <h3 class="card-title">Messages</h3>
                        <h4 id="chatWith" class="ml-auto" style="font-weight: bold;">Select a User</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Inbox Section -->
                            <div class="col-md-4" style="border-right: 1px solid #ddd;">
                                <h5>Inboxes</h5>
                                <!-- Search Box -->
                                <div class="mb-3">
                                    <!-- <input type="text" id="searchBox" class="form-control" placeholder="Search inboxes"> -->
                                    <ul id="searchResults" class="list-group mt-2"></ul>
                                </div>
                                <ul id="inboxList">
                                    <li class="list-group-item" id="chatBot" style="cursor: pointer;">ChatBot</li>
                                </ul>
                            </div>

                            <!-- Chatting Area -->
                            <div class="col-md-8">
                                <h5>Chat Area</h5>
                                <div id="chatWindow" class="chat-window" style="height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; background: #f9f9f9;">
                                    <!-- Chat messages will appear here -->
                                    <div id="questionList" class="question-list">
                                        <!-- Questions will be dynamically added here -->
                                    </div>
                                </div>
                                <form id="messageForm" style="margin-top: 10px;">
                                    <div class="input-group" id="inputGroup">
                                        <!-- <input type="text" id="messageInput" class="form-control" placeholder="Type a message"> -->
                                        <input type="text" id="receiverId" hidden>
                                        <input type="text" id="senderID" value="<?php echo $current_sess_id; ?>" hidden />
                                        <!-- <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Send</button>
                                        </div> -->
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
    const currentSessId = document.getElementById('senderID').value;
    const chatWith = document.getElementById('chatWith');
    const chatWindow = document.getElementById('chatWindow');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const inputGroup = document.getElementById('inputGroup');
    const questionList = document.getElementById('questionList');
    const chatBot = document.getElementById('chatBot');

    // Show ChatBot functionality
    chatBot.addEventListener('click', function() {
        chatWith.textContent = 'Chatting with: ChatBot';
        inputGroup.classList.add('d-none');
        fetchQuestions();
    });

    // Fetch questions from the server
    function fetchQuestions() {
        fetch('../realtimechat/fetch_chatbot_data.php') // Use the PHP file to fetch data
            .then(response => response.json())
            .then(data => {
                displayQuestions(data);
            })
            .catch(error => console.error('Error fetching questions:', error));
    }

    // Display questions in the middle
    let currentQuestions = []; // Store all questions to manage filtering
let chatHistory = []; // Store the history of chat messages (question-answer pairs)
let isFirstMessage = true; // Flag to check if it's the first message

// Fetch and display questions
function displayQuestions(questions) {
    currentQuestions = questions; // Store the questions in the array
    questionList.innerHTML = ''; // Clear previous questions

    questions.forEach(question => {
        const questionItem = document.createElement('div');
        questionItem.textContent = question.question;
        questionItem.className = 'question-item';
        questionItem.style.cursor = 'pointer';
        questionItem.addEventListener('click', () => showAnswer(question.id, question.answer, question.question));
        questionList.appendChild(questionItem);
    });
}

// Show the question on the right and the answer on the left (like a conversation history)
function showAnswer(questionId, answer, question) {
    // Display Question on the Right
    const messageElementQuestion = document.createElement('div');
    messageElementQuestion.className = 'message';
    messageElementQuestion.innerHTML = `<strong>${question}</strong> `;
    messageElementQuestion.style.textAlign = 'right'; // Align question to the right

    // Append the new question to the chat window (history)
    chatWindow.appendChild(messageElementQuestion);

    // Add the question-answer pair to the chat history
    chatHistory.push({ question, answer });

    // Remove the clicked question from the currentQuestions array
    currentQuestions = currentQuestions.filter(q => q.id !== questionId);

    // Typing animation for answer
    const messageElementAnswer = document.createElement('div');
    messageElementAnswer.className = 'message';
    messageElementAnswer.style.textAlign = 'left'; // Align answer to the left

    chatWindow.appendChild(messageElementAnswer); // Append the answer placeholder first

    // Trigger typing animation for the answer
    typeAnswer(messageElementAnswer, answer);

    // Update the question list only below the last question-answer pair
    updateQuestionList();

    // Scroll to the latest message
    chatWindow.scrollTop = chatWindow.scrollHeight;
}

// Typing animation function
function typeAnswer(element, text) {
    let i = 0;
    const speed = 30; // Speed of typing in ms
    const typingInterval = setInterval(() => {
        element.innerHTML += text.charAt(i);
        i++;
        if (i === text.length) {
            clearInterval(typingInterval); // Stop typing once all letters are typed
        }
    }, speed);
}

// Function to update the question list and show it below the conversation
function updateQuestionList() {
    // Remove the question list from the previous conversation
    const existingQuestionList = chatWindow.querySelector('.question-list');
    if (existingQuestionList) {
        existingQuestionList.remove(); // Remove the previous question list
    }

    // Create a new div for the remaining question list and apply the same styling
    const remainingQuestionsDiv = document.createElement('div');
    remainingQuestionsDiv.className = 'question-list'; // Apply the same class as question list

    // Add the remaining questions below the chat history
    currentQuestions.forEach(question => {
        const questionItem = document.createElement('div');
        questionItem.textContent = question.question;
        questionItem.className = 'question-item'; // Apply the same class as question item
        questionItem.style.cursor = 'pointer';
        questionItem.addEventListener('click', () => showAnswer(question.id, question.answer, question.question));
        remainingQuestionsDiv.appendChild(questionItem);
    });

    // Append the remaining questions below the last question-answer pair
    chatWindow.appendChild(remainingQuestionsDiv);

    // Scroll to the latest message
    chatWindow.scrollTop = chatWindow.scrollHeight;
}




    // Send a message (you can adapt this to send a user message to the chatbot)
    messageForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const message = messageInput.value;

        if (message) {
            const messageElement = document.createElement('div');
            messageElement.innerHTML = `<strong>You:</strong> ${message}`;
            messageElement.className = 'message';
            chatWindow.appendChild(messageElement);

            chatWindow.scrollTop = chatWindow.scrollHeight;
            messageInput.value = '';
        } else {
            alert('Please enter a message.');
        }
    });

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

        // Show typing area and send button for normal users
        inputGroup.classList.remove('d-none');

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

<?php
include('../userpage/appointment_modal.php');
?>

  </main>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>





<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if a success message is stored in session storage
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            // Display Alertify notification
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);

            // Remove the message from session storage
            sessionStorage.removeItem('successMessage');
        }
    });
</script>
<script>
    document.getElementById('province').addEventListener('change', function () {
        const province = this.value;
        const municipalitySelect = document.getElementById('municipality');
        const barangaySelect = document.getElementById('barangay');

        municipalitySelect.innerHTML = '<option value="" disabled selected>Select Municipality</option>';
        barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

        if (province) {
            const municipalities = <?php echo json_encode($locations); ?>[province];
            for (const municipality in municipalities) {
                municipalitySelect.innerHTML += `<option value="${municipality}">${municipality}</option>`;
            }
        }
    });

    document.getElementById('municipality').addEventListener('change', function () {
        const province = document.getElementById('province').value;
        const municipality = this.value;
        const barangaySelect = document.getElementById('barangay');

        barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

        if (province && municipality) {
            const barangays = <?php echo json_encode($locations); ?>[province][municipality];
            barangays.forEach(function (barangay) {
                barangaySelect.innerHTML += `<option value="${barangay}">${barangay}</option>`;
            });
        }
    });
</script>


<?php
include('../userpage/footer.php');
?>