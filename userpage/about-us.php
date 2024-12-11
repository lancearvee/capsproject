<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../assets/css/schedule.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="../assets/image/logo.png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../userpage/user-page.html">Home</a></li>
                <li><a href="../userpage/appointment.html">Appointment</a></li>
                <li><button class="menu-toggle" id="menu-toggle">&#9776;</button></li>
            </ul>
        </nav>
    </header>
   
    <div class="dropdown-menu" id="dropdown-menu">
        <ul>
            <li><a href="../userpage/edit-profile.php">Profile</a></li>
            <li><a href="../userpage/change-password.php">Change Password</a></li>
            <li><a href="../userpage/schedule.php">Schedule</a></li>
            <li><a href="../userpage/about-us.php" class="active">About Us</a></li>
            <li><a href="../userpage/contact.php">Contact</a></li>
            <li><a href="../userLogin/landing.php">Logout</a></li>
        </ul>
    </div>

    <main>
        <section class="about-us">
            <h1>About Us</h1>
            <p>Welcome to Thyroid Health And Wellness!</p>
            <p>At Thyroid Health And Wellness, we are committed to helping individuals take control of their thyroid health through accessible and reliable health services. Founded on the values of compassion, accuracy, and empowerment, our mission is to support you on your journey toward optimal well-being.</p>
            <p>Our focus is simple: to provide a trusted platform for thyroid health. We offer comprehensive lab services and checkups tailored specifically to thyroid health, ensuring that you receive the insights and support you need to feel your best.</p>
            <p>Our team believes in the power of proactive health management. With a commitment to high-quality service and accurate results, we strive to empower you to make informed decisions about your health. Thyroid health is essential for overall wellness, and we’re here to help you understand, monitor, and maintain it effectively.</p>
            <p>Whether you’re seeking a routine checkup, targeted lab services, or personalized guidance, Thyroid Health And Wellness is here to support you every step of the way. Let’s work together to achieve a healthier, more balanced life.</p>
        </section>
    </main>

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
