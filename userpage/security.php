<?php
include('../userpage/header.php');
require '../userLogin/db_con.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
$user_id = $_SESSION['user_id'];
?>

<main class="main">
    <section id="security" class="security section">
        <div class="container section-title text-center" data-aos="fade-up">
            <h2>Change Password</h2>
            <p>Update your account password to keep your account secure.</p>
        </div>

        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <form id="changePasswordForm" method="POST">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('current_password')">
                                    <i class="ri-eye-line text-primary"></i>
                                </button>
                            </div>
                            <?php if (isset($_SESSION['error_current_password'])): ?>
                                <div class="text-danger"><?= $_SESSION['error_current_password'] ?></div>
                                <?php unset($_SESSION['error_current_password']); ?>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password')">
                                    <i class="ri-eye-line text-primary"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                Your password must be 8-20 characters long.
                            </div>
                            <?php if (isset($_SESSION['error_new_password'])): ?>
                                <div class="text-danger"><?= $_SESSION['error_new_password'] ?></div>
                                <?php unset($_SESSION['error_new_password']); ?>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirm_password')">
                                    <i class="ri-eye-line text-primary"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                Your password must be 8-20 characters long.
                            </div>
                            <?php if (isset($_SESSION['error_confirm_password'])): ?>
                                <div class="text-danger"><?= $_SESSION['error_confirm_password'] ?></div>
                                <?php unset($_SESSION['error_confirm_password']); ?>
                            <?php endif; ?>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
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
document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to change your password?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../backendUser/change_password.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Changed',
                        text: data.message
                    }).then(() => {
                        document.getElementById('changePasswordForm').reset();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error changing your password. Please try again.'
                });
            });
        }
    });
});

function togglePasswordVisibility(fieldId) {
    var passwordInput = document.getElementById(fieldId);
    var passwordButton = passwordInput.nextElementSibling.querySelector('i');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordButton.classList.remove('ri-eye-line');
        passwordButton.classList.add('ri-eye-off-line');
    } else {
        passwordInput.type = 'password';
        passwordButton.classList.remove('ri-eye-off-line');
        passwordButton.classList.add('ri-eye-line');
    }
}
</script>