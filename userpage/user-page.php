<?php
session_start(); // Start the session first

// Include the database configuration file
$path = $_SERVER['DOCUMENT_ROOT'] . '/capstone/userLogin/db_con.php';
if (file_exists($path)) {
    include($path);
} else {
    die('Error: Unable to include the database configuration file at ' . $path);
}

// Check if the user is logged in
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit; // Prevent further script execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Care</title>
    <link rel="stylesheet" href="../assets/css/user-page.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../assets/image/logo.png" alt="Logo">
    </div>
    <div class="h2"><p>Thyroid Health And Wellness Center</p></div>
    <nav>
        <ul>
            <li><a href="../userpage/user-page.php">Home</a></li>
            <li><a href="../userpage/appointment.php" class="active">Appointment</a></li>
            <li>
                <button class="menu-toggle" id="menu-toggle">&#9776;</button>
            </li>
        </ul>
    </nav>
</header>

<div class="dropdown-menu" id="dropdown-menu">
    <ul>
        <li><a href="../userpage/edit-profile.php">Profile</a></li>
        <li><a href="../userpage/change-password.php">Change Password</a></li>
        <li><a href="../userpage/schedule.php">Schedule</a></li>
        <li><a href="../userpage/about-us.php">About Us</a></li>
        <li><a href="../userpage/contact.php">Contact</a></li>
        <li><a href="../userLogin/landing.php">Logout</a></li>
    </ul>
</div>


    <section class="hero">
        <div class="hero-text">
            <h1>Your Health, Our Priority</h1>
            <p>Prioritizing your health, <br>
            Committed to your strength, <br>
            Your partner in thyroid care, <br>
            Wellness for a better life, we’re here</p>
            <a href="profile-form.php" class="btn">Book Now</a>
        </div>
        <div class="doctor-image">
            <img src="../assets/image/image.png" alt="Doctor">
        </div>
    </section>
    <section class="features">
        <div class="feature">
            <img src="../assets/image/Services.png" alt="Services">
            <h3>Services</h3>
        </div>
        <div class="feature">
            <img src="../assets/image/Google Calendar.png" alt="Appointment">
            <h3>Appointment</h3>
        </div>
        <div class="feature">
            <img src="../assets/image/Edit Calendar.png" alt="Schedule">
            <h3>Schedule</h3>
        </div>
        <button id="chatbot-button" class="chatbot-button">
    💬
</button>

<!-- Chatbot Modal -->
<div id="chatbot-modal" class="chatbot-modal">
    <div class="chatbot-modal-content">
        <div class="chatbot-header">
            <span id="chatbot-close" class="chatbot-close">&times;</span>
            <h3>Chat with Us</h3>
        </div>
        <div class="chatbox">
            <div id="chatbox-messages" class="chatbox-messages"></div>
            <div class="chatbox-input-container">
                <input type="text" id="chatbox-input" placeholder="Type your message..." class="chatbox-input">
                <button id="chatbox-send" class="chatbox-send">Send</button>
            </div>
        </div>
    </div>
</div>

    </section>

</body>
<script>
const chatbotButton = document.getElementById("chatbot-button");
const chatbotModal = document.getElementById("chatbot-modal");
const chatbotClose = document.getElementById("chatbot-close");

// Show the chatbot modal when the button is clicked
chatbotButton.addEventListener("click", () => {
    chatbotModal.style.display = "block";
    scrollToBottom(); // Scroll to the bottom when the modal opens
});

// Close the chatbot modal when the close button is clicked
chatbotClose.addEventListener("click", () => {
    chatbotModal.style.display = "none";
});

// Close the modal if the user clicks outside of it
window.addEventListener("click", (event) => {
    if (event.target === chatbotModal) {
        chatbotModal.style.display = "none";
    }
});

// Handle sending messages (just for UI demonstration, not functional yet)
const chatboxSend = document.getElementById("chatbox-send");
const chatboxMessages = document.getElementById("chatbox-messages");
const chatboxInput = document.getElementById("chatbox-input");

chatboxSend.addEventListener("click", () => {
    const message = chatboxInput.value.trim();
    if (message) {
        // Create a new message bubble and add it to the messages
        const messageBubble = document.createElement("div");
        messageBubble.classList.add("chatbox-message", "user-message");
        messageBubble.textContent = message;
        chatboxMessages.appendChild(messageBubble);

        // Create bot's reply (mock response)
        setTimeout(() => {
            const botReply = document.createElement("div");
            botReply.classList.add("chatbox-message", "bot-message");
            botReply.textContent = "This is a bot reply. How can I help you?";
            chatboxMessages.appendChild(botReply);
            scrollToBottom(); // Scroll to the bottom when the bot replies
        }, 1000);

        // Clear the input field
        chatboxInput.value = "";
    }
});

// Function to scroll to the bottom of the chatbox
function scrollToBottom() {
    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
}

// Get the toggle button and dropdown menu elements
const menuToggle = document.getElementById("menu-toggle");
const dropdownMenu = document.getElementById("dropdown-menu");

// Toggle the dropdown menu on button click
menuToggle.addEventListener("click", (event) => {
    event.stopPropagation(); // Prevent click event from propagating to the window
    dropdownMenu.classList.toggle("show"); // Toggle the 'show' class
});

// Hide dropdown menu when clicking outside of it
window.addEventListener("click", (event) => {
    if (!dropdownMenu.contains(event.target) && !menuToggle.contains(event.target)) {
        dropdownMenu.classList.remove("show"); // Hide the dropdown menu
    }
});

    </script>
</html>
