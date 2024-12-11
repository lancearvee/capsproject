<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thyroid Health And Wellness Center</title>
    <link rel="stylesheet" href="../assets/css/appointment-sched.css">
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
        <section class="schedule-container">
            <h1>Thyroid Health And Wellness Center</h1>
            <h2>Thursday, Nov 15, 2024</h2>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Available Slots</th>
                        <th>In Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><button class="time-btn">09:00 AM</button></td>
                        <td>10</td>
                        <td>100%</td>
                    </tr>
                    <tr>
                        <td><button class="time-btn">10:00 AM</button></td>
                        <td>9</td>
                        <td>90%</td>
                    </tr>
                    <tr>
                        <td><button class="time-btn">11:00 AM</button></td>
                        <td>7</td>
                        <td>70%</td>
                    </tr>
                    <tr class="full">
                        <td>12:00 PM</td>
                        <td colspan="2">FULL</td>
                    </tr>
                    <tr>
                        <td><button class="time-btn">01:00 PM</button></td>
                        <td>7</td>
                        <td>70%</td>
                    </tr>
                    <tr>
                        <td><button class="time-btn">02:00 PM</button></td>
                        <td>5</td>
                        <td>50%</td>
                    </tr>
                    <tr>
                        <td><button class="time-btn">03:00 PM</button></td>
                        <td>6</td>
                        <td>60%</td>
                    </tr>
                    <tr>
                        <td><button class="time-btn">04:00 PM</button></td>
                        <td>6</td>
                        <td>60%</td>
                    </tr>
                    <tr>
                        <td><button class="time-btn">05:00 PM</button></td>
                        <td>8</td>
                        <td>80%</td>
                    </tr>
                </tbody>
            </table>
            <div class="navigation-buttons">
                <button class="nav-btn back" onclick="window.location.href='../userpage/appointment.php'">Back</button>

                <button class="nav-btn next" onclick="window.location.href='../userpage/appointment-review.php'">Next</button>

            </div>
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
