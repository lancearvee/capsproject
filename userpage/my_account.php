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
$user_id = $_SESSION['user_id'];

$query = "SELECT name, email FROM users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$name = $email = '';

if ($data) {
    $name = $data['name'];
    $email = $data['email'];
} else {
    echo "No data found for this user.";
}
?>

<main class="main">
    <section id="profile" class="profile section">
        <div class="container section-title text-center" data-aos="fade-up">
            <h2>My Account</h2>
            <p>View and update your profile information.</p>
        </div>

        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <form id="profileForm" action="../backendUser/update_profile.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name) ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" disabled>
                        </div>
                        <div class="text-center">
                            <button type="button" id="editButton" class="btn btn-primary">Update Profile</button>
                            <button type="submit" id="saveButton" class="btn btn-success" style="display: none;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
include('../userpage/footer.php');
?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('editButton').addEventListener('click', function() {
    document.getElementById('name').disabled = false;
    document.getElementById('email').disabled = false;
    document.getElementById('editButton').style.display = 'none';
    document.getElementById('saveButton').style.display = 'inline-block';
});

document.getElementById('profileForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);

    fetch('../backendUser/update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated',
                text: 'Your profile has been updated successfully.'
            });
            document.getElementById('name').disabled = true;
            document.getElementById('email').disabled = true;
            document.getElementById('editButton').style.display = 'inline-block';
            document.getElementById('saveButton').style.display = 'none';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'There was an error updating your profile. Please try again.'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'There was an error updating your profile. Please try again.'
        });
    });
});
</script>