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

$statuses = ['Pending', 'Approved', 'Completed', 'Cancelled'];

$appointments = [];
foreach ($statuses as $status) {
    $stmt = $pdo->prepare("
        SELECT id, time_to, time_from, date, given_name, middle_name, family_name, suffix 
        FROM appointments 
        WHERE status = :status AND user_id = :user_id
    ");
    $stmt->execute(['status' => $status, 'user_id' => $user_id]);
    $appointments[$status] = $stmt->fetchAll();
}

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
} else {
    echo "No data found for this user.";
}
?>




<main class="main">

    <!-- Appointment Section -->
    <section id="appointment" class="appointment section">

        <!-- Section Title -->
        <div class="container section-title text-center" data-aos="fade-up">
            <h2>My Appointments</h2>
            <p>View and manage your upcoming appointments effortlessly to stay on top of your health and well-being.</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="container" data-aos="fade-up">
            <ul class="nav nav-tabs justify-content-center" id="appointmentTabs" role="tablist">
                <?php foreach ($statuses as $index => $status): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" 
                                id="<?= strtolower($status) ?>-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#<?= strtolower($status) ?>" 
                                type="button" 
                                role="tab" 
                                aria-controls="<?= strtolower($status) ?>" 
                                aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                            <?= $status ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content container" data-aos="fade-up">
            <?php foreach ($statuses as $index => $status): ?>
                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" 
                     id="<?= strtolower($status) ?>" 
                     role="tabpanel" 
                     aria-labelledby="<?= strtolower($status) ?>-tab">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Time</th>
                                <th>Date</th>
                                <th>Fullname</th>
                                <th>Cancel</th> <!-- New Column -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($appointments[$status])): ?>
                                <?php foreach ($appointments[$status] as $appointment): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($appointment['id']) ?></td>
                                        <td>
                                            <?php
                                                $time_from = new DateTime(htmlspecialchars($appointment['time_from']));
                                                $time_to = new DateTime(htmlspecialchars($appointment['time_to']));
                                            ?>
                                            <?= $time_from->format('g:i A') ?> to <?= $time_to->format('g:i A') ?>
                                        </td>
                                        <td><?php echo date('F j, Y', strtotime($appointment['date'])); ?></td>
                                        <td>
                                            <?= htmlspecialchars($appointment['given_name']) . ' ' . 
                                                htmlspecialchars($appointment['middle_name']) . ' ' . 
                                                htmlspecialchars($appointment['family_name']) . ' ' . 
                                                htmlspecialchars($appointment['suffix']) ?>
                                        </td>
                                        <td>
                                            <?php if ($status == 'Pending' || $status == 'Approved'): ?>
                                                <button class="btn btn-danger btn-sm cancel-btn" 
                                                        data-appointment-id="<?= htmlspecialchars($appointment['id']) ?>">
                                                    Cancel
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No appointments found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>


<?php
include('../userpage/appointment_modal.php');
?>

</section>


  </main>

  <script>
    // Handle Cancel button click
    document.querySelectorAll('.cancel-btn').forEach(button => {
        button.addEventListener('click', function() {
            const appointmentId = this.getAttribute('data-appointment-id');

            // Show SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this appointment!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit to cancel_appointment.php
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '../backendUser/cancel_appointment.php';

                    // Create hidden input field with appointment ID
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'appointment_id';
                    input.value = appointmentId;

                    form.appendChild(input);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if a success message is stored in session storage
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            // Display Alertify notification
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);

            // Remove the message from session storage
            sessionStorage.removeItem('successMessage');
        }
    });
</script>
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


<?php
include('../userpage/footer.php');
?>