<?php
include('../adminpage/header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['staff_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
?>
<?php
require '../userLogin/db_con.php';

$sql = "SELECT id, time_from, time_to, date, family_name, middle_name, given_name, suffix, date_of_birth, gender, province, municipality, barangay, contact_number, email, postal_code, medical_history FROM appointments WHERE status = 'Pending'";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $appointments = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            <div class="card-header" style="display: flex; align-items: center;">
                <h3 class="card-title">Pending Appointments</h3>
                <div style="margin-left: auto; display: flex; gap: 0.5rem;">
                    <button type="button" class="btn btn-success btn-sm" id="submitButton" style="margin-left: auto; display: none;" onclick="processSelected()"> 
                        Approve
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="cancelButton" style="margin-left: auto; display: none;" onclick="processCancelSelected()"> 
                        Cancel
                    </button>
                </div>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll" onclick="selectAllCheckboxes()"></th>       
                            <th>Schedule</th>
                            <th>Date</th>
                            <th>Province</th>
                            <th>Municipality</th>
                            <th>Barangay</th>
                            <th>Contact Number</th>
                            <th>Medical History</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><input type="checkbox" class="rowCheckbox" value="<?php echo $appointment['id']; ?>"> 
                                <input type="hidden" class="id" value="<?php echo $appointment['id']; ?>">
                                <input type="hidden" class="email" value="<?php echo $appointment['email']; ?>">
                                <input type="hidden" class="given_name" value="<?php echo $appointment['given_name']; ?>">
                                <input type="hidden" class="date" value="<?php echo $appointment['date']; ?>">
                                <input type="hidden" class="time_from" value="<?php echo $appointment['time_from']; ?>">
                                <input type="hidden" class="time_to" value="<?php echo $appointment['time_to']; ?>">
                                <input type="hidden" class="location" value="<?php echo $appointment['province'] . ', ' . $appointment['municipality'] . ', ' . $appointment['barangay']; ?>">
                            </td>
                           
                            <td>
                                <?php
                                $time_from = date('h:i A', strtotime($appointment['time_from']));
                                $time_to = date('h:i A', strtotime($appointment['time_to']));
                                echo $time_from . ' - ' . $time_to;
                                ?>
                            </td>
                            <td>
                                <?php
                                $date = date('F j, Y', strtotime($appointment['date'])); 
                                echo $date;
                                ?>
                            </td>
                            <td><?php echo $appointment['province']; ?></td>
                            <td><?php echo $appointment['municipality']; ?></td>
                            <td><?php echo $appointment['barangay']; ?></td>
                            <td><?php echo $appointment['contact_number']; ?></td>
                            <td><?php echo $appointment['medical_history']; ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-<?php echo $appointment['id']; ?>">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <form method="POST" action="../backendAdmin/approved.php" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $appointment['id']; ?>">
                                    <input type="hidden" name="email" value="<?php echo $appointment['email']; ?>">
                                    <input type="hidden" name="given_name" value="<?php echo $appointment['given_name']; ?>">
                                    <input type="hidden" name="date" value="<?php echo $appointment['date']; ?>">
                                    <input type="hidden" name="time_from" value="<?php echo $appointment['time_from']; ?>">
                                    <input type="hidden" name="time_to" value="<?php echo $appointment['time_to']; ?>">
                                    <input type="hidden" name="location" value="<?php echo $appointment['province'] . ', ' . $appointment['municipality'] . ', ' . $appointment['barangay']; ?>">
                                    <button type="button" class="btn btn-success btn-sm approve-btn">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>

                                <form method="POST" action="../backendAdmin/cancel_appointment.php" style="display: inline;">
                                    <input type="hidden" name="id" value="<?php echo $appointment['id']; ?>">
                                    <input type="hidden" name="email" value="<?php echo $appointment['email']; ?>">
                                    <input type="hidden" name="given_name" value="<?php echo $appointment['given_name']; ?>">
                                    <input type="hidden" name="date" value="<?php echo $appointment['date']; ?>">
                                    <input type="hidden" name="time_from" value="<?php echo $appointment['time_from']; ?>">
                                    <input type="hidden" name="time_to" value="<?php echo $appointment['time_to']; ?>">
                                    <input type="hidden" name="location" value="<?php echo $appointment['province'] . ', ' . $appointment['municipality'] . ', ' . $appointment['barangay']; ?>">
                                    <button type="button" class="btn btn-danger btn-sm cancel-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>


                        <!-- Modal for each appointment -->
                        <div class="modal fade" id="modal-<?php echo $appointment['id']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <?php if (!empty($appointment['given_name'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Firstname:</strong> <?php echo $appointment['given_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['middle_name'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Middlename:</strong> <?php echo $appointment['middle_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['family_name'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Lastname:</strong> <?php echo $appointment['family_name']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['suffix'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Suffix:</strong> <?php echo $appointment['suffix']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['gender'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Sex:</strong> <?php echo $appointment['gender']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['date_of_birth'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Date of Birth:</strong> <?php echo $appointment['date_of_birth']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['email'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Email:</strong> <?php echo $appointment['email']; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($appointment['postal_code'])): ?>
                                                <div class="col-12 mb-2">
                                                    <strong>Postal Code:</strong> <?php echo $appointment['postal_code']; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  function selectAllCheckboxes() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.rowCheckbox');
    checkboxes.forEach(checkbox => {
      checkbox.checked = selectAll.checked;
    });
    toggleButtonVisibility();
  }

  function toggleButtonVisibility() {
    const checkboxes = document.querySelectorAll('.rowCheckbox');
    const submitButton = document.getElementById('submitButton');
    const cancelButton = document.getElementById('cancelButton');
    const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
    
    if (anyChecked) {
      submitButton.style.display = 'inline-block';
      cancelButton.style.display = 'inline-block';

    } else {
      submitButton.style.display = 'none';
      cancelButton.style.display = 'none';
    }
  }

  document.querySelectorAll('.rowCheckbox').forEach(checkbox => {
    checkbox.addEventListener('change', toggleButtonVisibility);
  });


  function processSelected() {
    var selectedAppointments = [];
    document.querySelectorAll('.rowCheckbox:checked').forEach(function(checkbox) {
        var row = checkbox.closest('td');
        var id = row.querySelector('.id').value;
        var email = row.querySelector('.email').value;
        var given_name = row.querySelector('.given_name').value;
        var date = row.querySelector('.date').value;
        var time_from = row.querySelector('.time_from').value;
        var time_to = row.querySelector('.time_to').value;
        var location = row.querySelector('.location').value;

        selectedAppointments.push({
            id: id,
            email: email,
            given_name: given_name,
            date: date,
            time_from: time_from,
            time_to: time_to,
            location: location
        });
    });

    if (selectedAppointments.length === 0) {
        Swal.fire('No appointments selected', '', 'warning');
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to approve the selected appointments and send emails?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, approve!',
        cancelButtonText: 'No, cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sending emails...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../backendAdmin/multiple_approve.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    Swal.close();

                    Swal.fire('Success', 'Appointment approved and emails sent!', 'success')
                        .then(() => location.reload());
                }
            };

            xhr.send(JSON.stringify(selectedAppointments));
        }
    });
}



///////////////////////////////////
function processCancelSelected() {
    var selectedAppointments = [];
    document.querySelectorAll('.rowCheckbox:checked').forEach(function(checkbox) {
        var row = checkbox.closest('td');
        var id = row.querySelector('.id').value;
        var email = row.querySelector('.email').value;
        var given_name = row.querySelector('.given_name').value;
        var date = row.querySelector('.date').value;
        var time_from = row.querySelector('.time_from').value;
        var time_to = row.querySelector('.time_to').value;
        var location = row.querySelector('.location').value;

        selectedAppointments.push({
            id: id,
            email: email,
            given_name: given_name,
            date: date,
            time_from: time_from,
            time_to: time_to,
            location: location
        });
    });

    if (selectedAppointments.length === 0) {
        Swal.fire('No appointments selected', '', 'warning');
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to reject the selected appointments and send emails?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Sending emails...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../backendAdmin/multiple_reject.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    Swal.close();

                    Swal.fire('Success', 'Appointment rejected and emails sent!', 'success')
                        .then(() => location.reload());
                }
            };

            xhr.send(JSON.stringify(selectedAppointments));
        }
    });
}


// Approve Form Submission
document.querySelectorAll('.approve-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the form from submitting immediately
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to approve this appointment?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show "Sending emails..." loading spinner
                Swal.fire({
                    title: 'Sending emails...',
                    text: 'Please wait while we process your request.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit the form after the loading alert is shown
                this.closest('form').submit();
            }
        });
    });
});

// Cancel Form Submission
document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the form from submitting immediately
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to cancel this appointment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show "Sending emails..." loading spinner
                Swal.fire({
                    title: 'Sending emails...',
                    text: 'Please wait while we process your request.',
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit the form after the loading alert is shown
                this.closest('form').submit();
            }
        });
    });
});


  


</script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(successMessage);

            sessionStorage.removeItem('successMessage');
        }
    });
</script>
<?php
include('../adminpage/footer.php');
?>