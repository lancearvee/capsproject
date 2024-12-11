<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Form</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
<header>
        <div class="logo">
            <img src="../assets/image/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../userpage/user-page.php">Home</a></li>
                <li><a href="../userpage/appointment.php" class="active">Appointment</a></li>
                <li><button class="menu-toggle" id="menu-toggle">&#9776;</button></li>
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
    

    <section class="profile-section">
        <h2>Profile</h2>
     
        <!-- Profile Form -->
        <form class="profile-form" id="profileForm">
            <div class="form-row">
                <label for="title">Title (Mr./Mrs.)</label>
                <input type="text" id="title" name="title" disabled>
            </div>
            <div class="form-row">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first_name" disabled>
            </div>
            <div class="form-row">
                <label for="last-name">Last Name</label>
                <input type="text" id="last-name" name="last_name" disabled>
            </div>
            <div class="form-row">
                <label for="middle-name">Middle Name</label>
                <input type="text" id="middle-name" name="middle_name" disabled>
            </div>
            <div class="form-row">
                <label for="date-of-birth">Date of Birth</label>
                <input type="date" id="date-of-birth" name="date_of_birth" disabled>
            </div>
            <div class="form-row">
                <label>Gender</label>
                <label for="male">Male</label>
                <input type="radio" id="male" name="gender" value="male" disabled>
                <label for="female">Female</label>
                <input type="radio" id="female" name="gender" value="female" disabled>
            </div>
            <div class="form-row">
                <label for="municipality">Municipality</label>
                <input type="text" id="municipality" name="municipality_id" disabled>
            </div>
            <div class="form-row">
                <label for="contact-number">Contact Number</label>
                <input type="tel" id="contact-number" name="contact_number" disabled>
            </div>
            <div class="form-row">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" disabled>
            </div>
            <div class="form-row">
                <label for="address">Address</label>
                <textarea id="address" name="address" rows="3" disabled></textarea>
            </div>
            <div class="form-row">
                <label for="city">City</label>
                <input type="text" id="city" name="city" disabled>
            </div>
            <div class="form-row">
                <label for="state">State</label>
                <input type="text" id="state" name="state" disabled>
            </div>
            <div class="form-row">
                <label for="postal-code">Postal Code</label>
                <input type="text" id="postal-code" name="postal_code" disabled>
            </div>
            <div class="form-row">
                <label for="medical-history">Medical History</label>
                <textarea id="medical-history" name="medical_history" rows="4" disabled></textarea>
            </div>

           
        </form>
        <button type="button" class="toggle-btn" id="toggleBtn">Edit</button> 
    </section>
    
    
    
    
    <script>
        
        const menuToggle = document.getElementById("menu-toggle");
        const dropdownMenu = document.getElementById("dropdown-menu");

        menuToggle.addEventListener("click", () => {
            dropdownMenu.classList.toggle("show");
        });
 
        window.addEventListener("click", (event) => {
            if (!menuToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove("show");
            }
        });

     
        const toggleBtn = document.getElementById('toggleBtn');
const formFields = document.querySelectorAll('#profileForm input, #profileForm textarea');

toggleBtn.addEventListener('click', function () {
    if (toggleBtn.textContent === 'Edit') {
        
        formFields.forEach(field => field.disabled = false);
 
        toggleBtn.textContent = 'Save';
 
        toggleBtn.style.backgroundColor = '#5cb85c'; 
    } else {
         
        formFields.forEach(field => field.disabled = true);
 
        toggleBtn.textContent = 'Edit';

        
        toggleBtn.style.backgroundColor = 'gray'; 
 
        console.log('Form data saved!');
    }
});


    </script>
</body>
</html>
