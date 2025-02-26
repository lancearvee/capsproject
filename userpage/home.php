<?php
require '../userLogin/db_con.php'; 
include('../userpage/header.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../userpage/locations.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM patient_data WHERE user_id = :user_id";

$stmt = $pdo->prepare($query);

$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

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
} 

?>

<?php


// Initialize variables to hold the patient data

?>
<style>
    .search-box {
        margin-bottom: 10px;
        padding: 0 10px;
    }

    #search-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .chatbot-question {
        background-color: #f1f1f1;
        padding: 5px 10px;
        margin: 5px 0;
        cursor: pointer;
        text-align: center;
        align-self: center;
        max-width: 80%;
        border-radius: 5px;
        font-size: 14px;
    }

    .chatbot-question:hover {
        background-color: #ddd;
    }

    .chatbox-message {
    padding: 8px;
    margin: 4px 0;
    border-radius: 5px;
    max-width: 70%;
    word-wrap: break-word;
    display: inline-block;
    }

    .question {
        background-color: #e9e9e9; 
        align-self: flex-end;
        text-align: right;
    }

    .answer {
        background-color: #e1f7d5; 
        align-self: flex-start;
        text-align: left;
    }

    .chatbox-messages {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
    }

    .chatbox-input-container {
        display: flex;
        gap: 10px;
        padding: 10px;
    }

    .chatbox-input {
        width: 80%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .chatbox-send {
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .chatbox-send:hover {
        background-color: #0056b3;
    }

    .typing-indicator {
        font-style: italic;
        color: #aaa;
    }

    .user-inbox {
        max-height: 200px;
        overflow-y: auto;
        margin-bottom: 10px;
        padding: 10px;
    }

    .user-row {
        padding: 8px;
        cursor: pointer;
        background-color: #f5f5f5;
        margin: 5px 0;
        border-radius: 5px;
    }

    .user-row:hover {
        background-color: #ddd;
    }

    .chatbox-container {
        display: none; 
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    .chatbox-container.show {
        display: block;
        opacity: 1;
    }

    .back-to-inbox {
        background: none;
        border: none;
        color: #007bff;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        margin: 0;
        position: absolute;
        left: 10px;
        top: 10px;
    }

    .back-to-inbox i {
        font-size: 20px;
    }

    .back-to-inbox:hover {
        color: #0056b3;
    }
</style>
<main class="main">

<!-- Hero Section -->
<section id="hero" class="hero section light-background">

  <img src="../logintemplate/assets/images/products/lab1.jpg" alt="" data-aos="fade-in">
   
  <div class="container position-relative">

    <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
      <h2>WELCOME TO THYROID</h2>
      <p>Prioritizing your health, <br>
    Committed to your strength, <br>
    Your partner in thyroid care, <br>
    Wellness for a better life, we’re here</p>
    </div><!-- End Welcome -->

    <div class="content row gy-4">
      <div class="col-lg-4 d-flex align-items-stretch">
        <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
          <h3>Book Your Thyroid Appointment</h3>
          <p>Ready to take control of your thyroid health? Schedule an appointment today for expert care, early detection, and personalized treatment. Your well-being starts with the right support.
          </p>
          <div class="text-center">
          <a data-toggle="modal" data-target="#appointmentModal" role="button" class="more-btn">Make an Appointment<i class="bi bi-chevron-right"></i></a>
      
          </div>
        </div>
      </div><!-- End Why Box -->

      <div class="col-lg-8 d-flex align-items-stretch">
        <div class="d-flex flex-column justify-content-center">
          <div class="row gy-4">

            <div class="col-xl-4 d-flex align-items-stretch">
              <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                <i class="bi bi-clipboard-data"></i>
                <h4>Comprehensive Care and Diagnosis</h4>
                <p>Our services ensure accurate diagnosis and management of thyroid conditions, addressing your unique needs with precision.</p>
              </div>
            </div><!-- End Icon Box -->

            <div class="col-xl-4 d-flex align-items-stretch">
              <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                <i class="bi bi-gem"></i>
                <h4>Personalized Treatment Plans</h4>
                <p>We work closely with you to create tailored solutions for hypothyroidism, hyperthyroidism, and other thyroid-related issues, ensuring your well-being.</p>
              </div>
            </div><!-- End Icon Box -->

            <div class="col-xl-4 d-flex align-items-stretch">
              <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                <i class="bi bi-inboxes"></i>
                <h4>Empowering Your Health Journey</h4>
                <p>Our experts provide guidance and support, helping you achieve balance, energy, and improved quality of life through effective thyroid care.</p>
              </div>
            </div><!-- End Icon Box -->

          </div>
        </div>
      </div>
    </div><!-- End  Content-->

  </div>

</section><!-- /Hero Section -->


<section id="about" class="py-5 wow fadeInUp" data-wow-delay="0.1s">
<div class="container">
    <div class="row g-5">
        <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
            <div class="section-title mb-4">
                <h5 class="position-relative d-inline-block text-primary text-uppercase"></h5>
                <h1 class="display-5 mb-0">The Thyroid Care Clinic You Can Rely On</h1>
            </div>
            <h4 class="text-body fst-italic mb-4">We specialize in providing comprehensive thyroid health services.</h4>
            <p class="mb-4">Thyroid Health and Wellness provides accessible, reliable services to support thyroid health. We offer tailored lab services and checkups to help you make informed decisions for optimal well-being. Our goal is to empower you to achieve a healthier, balanced life.</p>
            <div class="row g-3">
                <div class="col-sm-6 wow zoomIn" data-wow-delay="0.3s">
                    <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Expert Guidance</h5>
                    <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Comprehensive Services</h5>
                </div>
                <div class="col-sm-6 wow zoomIn" data-wow-delay="0.6s">
                    <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Accessible Anytime</h5>
                    <h5 class="mb-3"><i class="fa fa-check-circle text-primary me-3"></i>Personalized Treatment</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-5 position-relative" style="min-height: 500px;"  data-aos="fade-up" data-aos-delay="200">
            <div class="position-relative h-100">
                <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s" src="../usertemplate/assets/img/thy.jpg" style="object-fit: cover;">
            </div>
        </div>
    </div>
</div>
</section>

<!-- About Section -->
<section id="about" class="about section">

  <div class="container">

    <div class="row gy-4 gx-5">

      <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
        <img src="../usertemplate/assets/img/ab.webp" class="img-fluid" alt="">
        <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
      </div>

      <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
        <h3>About Us</h3>
        <p>
        Thyroid Health and Wellness provides accessible, reliable services to support thyroid health. We offer tailored lab services and checkups to help you make informed decisions for optimal well-being. Our goal is to empower you to achieve a healthier, balanced life.
        </p>
        <ul>
          <li>
            <i class="fa-solid fa-vial-circle-check"></i>
            <div>
              <h5>Thyroid Health and Wellness:</h5>
              <p>Maximize your thyroid health with expert guidance and care. Our comprehensive services empower you to take control of your well-being, offering accurate diagnostics and personalized treatment plans to support optimal thyroid function.</p>
            </div>
          </li>
          <li>
            <i class="fa-solid fa-pump-medical"></i>
            <div>
              <h5>Support for Your Journey:</h5>
              <p>We are committed to providing reliable, accessible resources for maintaining thyroid balance. Whether you seek preventive care or targeted solutions, our team ensures you receive the insights needed to live a healthier, more balanced life.</p>
            </div>
          </li>
          <li>
            <i class="fa-solid fa-heart-circle-xmark"></i>
            <div>
              <h5>Your Wellness, Our Priority:</h5>
              <p>Understanding the importance of thyroid health, we work tirelessly to provide accurate assessments and actionable recommendations, helping you manage symptoms and improve your quality of life.</p>
            </div>
          </li>
        </ul>
      </div>

    </div>

  </div>

</section><!-- /About Section -->


<!-- Stats Section -->
<section id="stats" class="stats section light-background">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">

      <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
        <i class="fa-solid fa-user-doctor"></i>
        <div class="stats-item">
          <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>
          <p>Doctors</p>
        </div>
      </div><!-- End Stats Item -->

      <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
        <i class="fa-regular fa-hospital"></i>
        <div class="stats-item">
          <span data-purecounter-start="0" data-purecounter-end="18" data-purecounter-duration="1" class="purecounter"></span>
          <p>Departments</p>
        </div>
      </div><!-- End Stats Item -->

      <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
        <i class="fas fa-flask"></i>
        <div class="stats-item">
          <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>
          <p>Research Labs</p>
        </div>
      </div><!-- End Stats Item -->

      <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
        <i class="fas fa-award"></i>
        <div class="stats-item">
          <span data-purecounter-start="0" data-purecounter-end="150" data-purecounter-duration="1" class="purecounter"></span>
          <p>Awards</p>
        </div>
      </div><!-- End Stats Item -->

    </div>

  </div>

</section><!-- /Stats Section -->

<!-- Services Section -->
<section id="services" class="services section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Services</h2>
    <p>Our services ensure comprehensive care and diagnosis for thyroid-related conditions, addressing every need with precision and dedication.</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item  position-relative">
          <div class="icon">
            <i class="fas fa-heartbeat"></i>
          </div>
          <a href="#" class="stretched-link">
            <h3>The Vital Role of the Thyroid</h3>
          </a>
          <p>The thyroid gland plays a key role in regulating metabolism, energy levels, and overall health. Dysfunction can lead to conditions like hypothyroidism and hyperthyroidism, impacting daily life. Timely diagnosis and treatment are essential to maintaining your well-being.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-pills"></i>
          </div>
          <a href="#" class="stretched-link">
            <h3>Thyroid Disorders and Their Impact</h3>
          </a>
          <p>Thyroid imbalances can cause a wide range of symptoms, including fatigue, weight changes, mood swings, and heart issues. Proper care and early intervention can help manage these conditions and restore balance to your life.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-hospital-user"></i>
          </div>
          <a href="#" class="stretched-link">
            <h3>Advanced Thyroid Care Solutions</h3>
          </a>
          <p>Our expert care team provides cutting-edge diagnostics and treatments for thyroid health, ensuring personalized and effective solutions to improve your quality of life. Stay proactive and prioritize your thyroid health for long-term wellness.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-dna"></i>
          </div>
          <a href="#" class="stretched-link">
            <h3>Thyroid Health Importance</h3>
          </a>
          <p>The thyroid regulates many vital functions in the body, including metabolism, energy, and hormone balance. A malfunctioning thyroid can lead to significant health issues. Timely diagnosis and treatment are key to preventing further complications.</p>
          <a href="#" class="stretched-link"></a>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-wheelchair"></i>
          </div>
          <a href="#" class="stretched-link">
            <h3>Symptoms and Diagnosis of Thyroid Disorders</h3>
          </a>
          <p>Thyroid imbalances can present symptoms like fatigue, weight changes, and mood disturbances. It's essential to address these symptoms early through accurate diagnosis and targeted treatment for effective management.</p>
          <a href="#" class="stretched-link"></a>
        </div>
      </div><!-- End Service Item -->

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="service-item position-relative">
          <div class="icon">
            <i class="fas fa-notes-medical"></i>
          </div>
          <a href="#" class="stretched-link">
            <h3>Effective Solutions for Thyroid Care</h3>
          </a>
          <p>With personalized treatment options and expert guidance, managing thyroid disorders becomes more manageable. Stay proactive in your thyroid health to ensure lasting wellness and optimal function.</p>
          <a href="#" class="stretched-link"></a>
        </div>
      </div><!-- End Service Item -->

    </div>

  </div>

</section><!-- /Services Section -->



<!-- Departments Section -->


<!-- Doctors Section -->
<section id="doctors" class="doctors section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Doctors</h2>
    <p>Dedicated expert doctors committed to providing compassionate care and advanced medical services.</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

    <div class="col-lg-6 mx-auto" data-aos="fade-up" data-aos-delay="100">
<div class="team-member d-flex align-items-start justify-content-center">
    <div class="pic"><img src="../logintemplate/assets/images/products/doctor.jpg" class="img-fluid" alt=""></div>
    <div class="member-info text-center">
        <h4>Dr. Uzziel De Mesa</h4>
        <span>Internal Medicine-Endocrinology</span>
        <p>Dedicated to providing comprehensive care with expertise in managing endocrine disorders.</p>

        <div class="social">
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"> <i class="bi bi-linkedin"></i> </a>
        </div>
    </div>
</div>
</div><!-- End Team Member -->
    </div>

  </div>

</section> 
    
<?php
include('../userpage/appointment_modal.php');
?>
    
    <button id="chatbot-button" class="chatbot-button">
        💬
    </button>
    <div id="chatbot-modal" class="chatbot-modal">
      <div class="chatbot-modal-content">
          <div class="chatbot-header">
              <span id="chatbot-close" class="chatbot-close">&times;</span>
          </div>

          <div class="search-box">
              <input type="text" id="search-input" placeholder="Search users..." onkeyup="filterUsers()">
          </div>

          <div id="user-inbox" class="user-inbox">
          </div>

          <div id="chatbox-container" class="chatbox-container">
              <button id="back-to-inbox" class="back-to-inbox">
                  <i class="fa fa-arrow-left"></i> 
              </button>

              <div id="chatbox-messages" class="chatbox-messages">
              </div>
              <div class="chatbox-input-container">
                  <input type="text" id="chatbox-input" placeholder="Type your message..." class="chatbox-input">
                  <button id="chatbox-send" class="chatbox-send">Send</button>
              </div>
          </div>
      </div>
  </div>
  </main>
  




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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




<script>
let timeout; // To debounce search requests

const users = [
    { name: 'Chatbot', questions: ['How can I help you today?', 'What services do you offer?', 'Can I get more information?'] }
];

let searchQuery = ''; // Track the search query

// Function to fetch and populate the user list based on search query
async function fetchUsers(searchQuery = '') {
    try {
        const response = await fetch(`../backendUser/fetchUser_chat.php?search=${encodeURIComponent(searchQuery)}`);
        const fetchedUsers = await response.json();
        if (response.ok && Array.isArray(fetchedUsers)) {
            populateUserList(fetchedUsers);
        } else {
            console.error('Invalid response format:', fetchedUsers);
        }
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}

// Function to populate the user list with fetched or static users
function populateUserList(users) {
    const userInbox = document.getElementById('user-inbox');
    userInbox.innerHTML = ''; // Clear existing content

    // Filter users based on search query
    const filteredUsers = users.filter(user => user.name.toLowerCase().includes(searchQuery.toLowerCase()));

    // Display filtered users or a message if no users match
    if (filteredUsers.length === 0) {
        const noResultsMessage = document.createElement('div');
        noResultsMessage.classList.add('no-results');
        noResultsMessage.textContent = 'No users found';
        userInbox.appendChild(noResultsMessage);
    } else {
        filteredUsers.forEach(user => {
            const userRow = document.createElement('div');
            userRow.classList.add('user-row');
            userRow.textContent = user.name;
            userRow.onclick = () => redirectToChat(user.id, user.name);
            userInbox.appendChild(userRow);
        });
    }
}

// Function to redirect to chat with a user
function redirectToChat(userId, userName) {
    const chatboxContainer = document.getElementById('chatbox-container');
    const chatboxMessages = document.getElementById('chatbox-messages');
    const searchBox = document.querySelector('.search-box');

    // Hide the search box when redirecting to chat
    searchBox.style.display = 'none';

    // Hide user inbox and show chatbox
    document.getElementById('user-inbox').style.display = 'none';
    chatboxContainer.classList.add('show');

    // Display chat with user name and ID
    chatboxMessages.innerHTML = `<div class="chatbox-message"><strong>Chatting with ${userName} (ID: ${userId})</strong></div>`;
    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
}

// Function to filter users based on search input
function filterUsers() {
    const searchInput = document.getElementById('search-input').value.toLowerCase();
    searchQuery = searchInput; // Update the search query

    const userInbox = document.getElementById('user-inbox');

    // Delay fetching for better UX (debouncing)
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        if (searchInput === '') {
            // If the input is empty, show only the chatbot
            userInbox.innerHTML = '';
            const chatbotRow = document.createElement('div');
            chatbotRow.classList.add('user-row');
            chatbotRow.textContent = 'Chatbot';
            chatbotRow.onclick = () => loadUserMessages(0); // Assuming 0 is the chatbot's index
            userInbox.appendChild(chatbotRow);
        } else {
            fetchUsers(searchInput); // Fetch users based on search input
        }
    }, 300); // Adjust debounce time as needed
}

// Function to load messages for the selected user
function loadUserMessages(userIndex) {
    const chatboxMessages = document.getElementById('chatbox-messages');
    const chatboxContainer = document.getElementById('chatbox-container');
    const searchBox = document.querySelector('.search-box');
    const user = users[userIndex];
    const chatboxInputContainer = document.querySelector('.chatbox-input-container');

    // Hide user inbox and search box
    document.getElementById('user-inbox').style.display = 'none';
    searchBox.style.display = 'none';

    // Show chatbox
    chatboxContainer.classList.add('show');
    chatboxMessages.innerHTML = '';

    const typingIndicator = document.createElement('div');
    typingIndicator.classList.add('chatbox-message', 'typing-indicator');
    typingIndicator.textContent = '...typing';
    chatboxMessages.appendChild(typingIndicator);

    setTimeout(() => {
        chatboxMessages.removeChild(typingIndicator);

        user.questions.forEach(question => {
            const questionDiv = document.createElement('div');
            questionDiv.classList.add('chatbot-question');
            questionDiv.textContent = question;
            questionDiv.onclick = () => sendMessage(question, userIndex);
            chatboxMessages.appendChild(questionDiv);
        });
    }, 1000);

    // Hide the input container only when chatting with the chatbot (index 0)
    if (userIndex === 0) { // Chatbot index is 0
        chatboxInputContainer.style.display = 'none';  // Hide the input container for chatbot
    } else {
        chatboxInputContainer.style.display = 'block'; // Show input for real users
    }
}


// Function to send messages and receive bot responses
function sendMessage(message, userIndex) {
    const chatboxMessages = document.getElementById('chatbox-messages');
    const user = users[userIndex];

    const questionMessage = document.createElement('div');
    questionMessage.classList.add('chatbox-message', 'question');
    questionMessage.textContent = message;

    chatboxMessages.appendChild(questionMessage);
    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;

    const typingIndicator = document.createElement('div');
    typingIndicator.classList.add('chatbox-message', 'typing-indicator');
    typingIndicator.textContent = '...typing';
    chatboxMessages.appendChild(typingIndicator);

    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;

    setTimeout(() => {
        chatboxMessages.removeChild(typingIndicator);

        const answerMessage = document.createElement('div');
        answerMessage.classList.add('chatbox-message', 'answer');

        if (message === 'How can I help you today?') {
            answerMessage.textContent = 'I am here to assist you with any questions or issues!';
        } else if (message === 'What services do you offer?') {
            answerMessage.textContent = 'We offer a variety of services including customer support, troubleshooting, and more!';
        } else if (message === 'Can I get more information?') {
            answerMessage.textContent = 'Sure! What would you like to know more about?';
        } else {
            answerMessage.textContent = 'I am sorry, I didn’t understand that. Please try again.';
        }

        chatboxMessages.appendChild(answerMessage);
        chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
    }, 2000);
}

// Event listener for the search input to filter users dynamically
document.getElementById('search-input').addEventListener('input', filterUsers);

// Function to go back to the inbox
document.getElementById('back-to-inbox').addEventListener('click', function() {
    const chatboxContainer = document.getElementById('chatbox-container');
    const searchBox = document.querySelector('.search-box');
    const userInbox = document.getElementById('user-inbox');
    const chatboxInputContainer = document.querySelector('.chatbox-input-container');

    // Show user inbox and search box
    chatboxContainer.classList.remove('show');
    userInbox.style.display = 'block';
    searchBox.style.display = 'block';

    // Reset chat input container to be visible when coming back from the chatbot
    chatboxInputContainer.style.display = 'block'; // Always show for users
});

// Open/Close chatbot modal
const chatbotButton = document.getElementById("chatbot-button");
const chatbotModal = document.getElementById("chatbot-modal");
const chatbotClose = document.getElementById("chatbot-close");

chatbotButton.addEventListener("click", () => {
    chatbotModal.style.display = "block";
});

chatbotClose.addEventListener("click", () => {
    chatbotModal.style.display = "none";
});

window.addEventListener("click", (event) => {
    if (event.target === chatbotModal) {
        chatbotModal.style.display = "none";
    }
});

// Initialize the page with only the chatbot and no user list
window.onload = function () {
    const userInbox = document.getElementById('user-inbox');
    userInbox.innerHTML = ''; // Clear any previous content

    const chatbotRow = document.createElement('div');
    chatbotRow.classList.add('user-row');
    chatbotRow.textContent = 'Chatbot';
    chatbotRow.onclick = () => loadUserMessages(0); // Assuming 0 is the chatbot's index
    userInbox.appendChild(chatbotRow);

    // Initially, don't fetch users until a search is performed
    userInbox.style.display = 'block'; // Show only the chatbot
};

// Menu toggle functionality
const menuToggle = document.getElementById("menu-toggle");
const dropdownMenu = document.getElementById("dropdown-menu");

menuToggle.addEventListener("click", (event) => {
    event.stopPropagation();
    dropdownMenu.classList.toggle("show");
});

window.addEventListener("click", (event) => {
    if (!dropdownMenu.contains(event.target) && !menuToggle.contains(event.target)) {
        dropdownMenu.classList.remove("show");
    }
});
</script>


<?php
include('../userpage/footer.php');

?>