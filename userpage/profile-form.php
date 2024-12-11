<?php

    require '../userLogin/db_con.php';
    

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $family_name = $_POST['family-name'];
    $given_name = $_POST['given-name'];
    $middle_name = $_POST['middle-name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $municipality_id = $_POST['municipality_id'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postal_code = $_POST['postal_code'];
    $medical_history = $_POST['medical_history'];

    // Insert data into the database
    $sql = "INSERT INTO profiles (family_name, given_name, middle_name, date_of_birth, gender, municipality_id, contact_number, email, city, state, postal_code, medical_history)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssssss",
        $family_name,
        $given_name,
        $middle_name,
        $date_of_birth,
        $gender,
        $municipality_id,
        $contact_number,
        $email,
        $city,
        $state,
        $postal_code,
        $medical_history
    );

    if ($stmt->execute()) {
        echo "<p>Profile submitted successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

 
?>
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
        <div class="p2"><p>Thyroid Health And Wellness Center</p></div>
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
    <form class="profile-form" action="/submit-profile" method="POST">

        <div class="form-row">
            <label for="family-name">Last Name</label>
            <input type="text" id="family-name" name="family-name" placeholder="Enter family name" required>
        </div>

        <div class="form-row">
            <label for="given-name">First Name</label>
            <input type="text" id="given-name" name="given-name" placeholder="Enter given name" required>
        </div>

        <div class="form-row">
            <label for="middle-name">Middle Name</label>
            <input type="text" id="middle-name" name="middle-name" placeholder="Enter middle name" required>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="date_of_birth">Date of Birth<span class="h5 text-danger">*</span></label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
            </div>
        </div>

        <div class="form-row">
            <label>Gender</label>
            <div>
                <label for="male">Male</label>
                <input type="radio" id="male" name="gender" value="male" required>
                <label for="female">Female</label>
                <input type="radio" id="female" name="gender" value="female" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="municipality_id">Municipality</label>
                <select class="form-control" id="municipality_id" name="municipality_id" required>
                    <option value="" disabled selected>Select Municipality</option>
                    <option value="1">Calapan City</option>
                    <option value="2">Pinamalayan</option>
                    <option value="3">Scorro</option>
                    <option value="4">Bansud</option>
                    <option value="5">San Jose Occidental</option>
                    <option value="6">Mamburao Occidental</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="contact_number">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Enter contact number">
            </div>

            <div class="form-group col-md-4">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
            </div>

            <div class="form-group col-md-4">
                <label for="state">Province</label>
                <input type="text" class="form-control" id="state" name="state" placeholder="Enter province">
            </div>

            <div class="form-group col-md-4">
                <label for="postal_code">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter postal code">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="medical_history">Medical History</label>
                <textarea class="form-control" id="medical_history" name="medical_history" placeholder="Enter medical history"></textarea>
            </div>
        </div>

        <div class="form-buttons">
            <button type="button" class="back-btn" onclick="window.location.href='../userpage/user-page.php'">Back</button>
            <button type="submit" class="done-btn" onclick="window.location.href='../userpage/appointment.php'">Done</button>
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
