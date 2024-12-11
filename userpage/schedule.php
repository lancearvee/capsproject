<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Calendar</title>
    <link rel="stylesheet" href="../assets/css/schedule.css">
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
 
   <section class="appointment-schedule"> 

   
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
    </script>
</body>
</html>
</body>
</html>
