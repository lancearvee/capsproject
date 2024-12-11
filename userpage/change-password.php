<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Calendar</title>
    <link rel="stylesheet" href="../assets/css/change-pass.css">
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
    
    <section class="change-password-section">
        <h2>Change Password</h2>
        <form class="change-password-form" id="changePasswordForm" action="/submit-password-change" method="POST">
            <div class="form-row">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current-password" placeholder="Enter current password" required>
            </div>
    
            <div class="form-row">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>
            </div>
    
            <div class="form-row">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>
            </div>
    
            <div class="form-buttons">
                <button type="submit" class="save-btn">Save</button>
                <button type="button" class="cancel-btn" onclick="window.history.back()">Cancel</button>
            </div>
        </form>
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
