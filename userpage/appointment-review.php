<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Review</title>
    <link rel="stylesheet" href="../assets/css/appointment-review.css">
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
    

    

    <main>
        <section class="appointment-review">
            <h1>Please review the details of your appointment.</h1>
            <div class="appointment-details">
                <h2>Appointment Details</h2>
                <table>
                    <tr>
                        <td>First Name</td>
                        <td>John</td>
                    </tr>
                    <tr>
                        <td>Middle Name</td>
                        <td>Paul</td>
                    </tr>
                    <tr>
                        <td>Last Name</td>
                        <td>Doe</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>123 Main St</td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td>Nov 15, 2024</td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td>10:00 AM</td>
                    </tr>
                </table>
            </div>

            <div class="contact-info">
                <h2>Contact Information</h2>
                <table>
                    <tr>
                        <td>Email</td>
                        <td>john.doe@example.com</td>
                    </tr>
                    <tr>
                        <td>Mobile Number</td>
                        <td>123-456-7890</td>
                    </tr>
                </table>
            </div>

            <div class="navigation-buttons">
                <button class="nav-btn back" onclick="window.location.href='../userpage/appointment-sched.php'">Back</button>
                <button class="nav-btn confirm" id="confirm-btn">Confirm</button>
            </div>
        </section>
    </main>

  
    <div class="modal" id="review-modal">
        <div class="modal-content">
            <h1>Are you sure to your Appointment </h1>
            
            <p>First Name:John</p>
            <p>Middle Name: Paul</p>
            <p>Last Name: Doe</p>
            <p>Address: 123 Main St</p>
            <p>Date: Nov 15, 2024</p>
            <p>Time: 10:00 AM</p>
            <button class="modal-btn" id="close-modal-btn">Cancel</button>
            <button class="modal-btn" id="okay-modal-btn">Okay</button>
            
        </div>
    </div>

    <script>
       
        document.getElementById("confirm-btn").addEventListener("click", function () {
            document.getElementById("review-modal").style.display = "flex";
        });

        document.getElementById("close-modal-btn").addEventListener("click", function () {
            document.getElementById("review-modal").style.display = "none";
        });
  
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
    
        document.getElementById("okay-modal-btn").addEventListener("click", function() {
    window.location.href = "../userpage/user-page.php"; // Replace with your desired URL
});

    </script>
</body>
</html>
