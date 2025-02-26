<?php
include('../adminpage/header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
$admin_id = $_SESSION['admin_id'];
?>
<?php


include('../userpage/locations.php');

require '../userLogin/db_con.php';

$sql = "SELECT id, firstname, middlename, lastname, suffix, sex, province, municipality, barangay, civil_status, position, email, contact_no FROM staff";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll();

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
            <h3 class="card-title">Staff</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="margin-left: auto;">
                + Staff
            </button>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Sex</th>
                            <th>Address</th>
                            <th>Civil Status</th>
                            <th>Position</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['firstname']; ?></td>
                            <td><?php echo $user['sex']; ?></td>
                            <td><?php echo $user['province']; ?></td>
                            <td><?php echo $user['civil_status']; ?></td>
                            <td><?php echo $user['position']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['contact_no']; ?></td>

                            <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editUserModal<?php echo $user['id']; ?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                <i class="fa fa-trash"></i>
                            </button>

                            </td>
                        </tr>

                        <!-- Modal to display and edit user details -->
                            <div class="modal fade" id="editUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel<?php echo $user['id']; ?>">Edit User Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <form method="POST" action="../backendAdmin/update_staff.php">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="firstname">First Name</label>
                                                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $user['firstname'] ?? '' ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="middlename">Middle Name</label>
                                                        <input type="text" class="form-control" id="middlename" name="middlename" value="<?= $user['middlename'] ?? '' ?>">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label for="lastname">Last Name</label>
                                                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $user['lastname'] ?? '' ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="suffix">Suffix</label>
                                                        <select class="form-control" id="suffix" name="suffix">
                                                            <option value="">Select Suffix</option>
                                                            <option value="Jr." <?= isset($user['suffix']) && $user['suffix'] === 'Jr.' ? 'selected' : '' ?>>Jr.</option>
                                                            <option value="Sr." <?= isset($user['suffix']) && $user['suffix'] === 'Sr.' ? 'selected' : '' ?>>Sr.</option>
                                                            <option value="I" <?= isset($user['suffix']) && $user['suffix'] === 'I' ? 'selected' : '' ?>>I</option>
                                                            <option value="II" <?= isset($user['suffix']) && $user['suffix'] === 'II' ? 'selected' : '' ?>>II</option>
                                                            <option value="III" <?= isset($user['suffix']) && $user['suffix'] === 'III' ? 'selected' : '' ?>>III</option>
                                                            <option value="IV" <?= isset($user['suffix']) && $user['suffix'] === 'IV' ? 'selected' : '' ?>>IV</option>
                                                            <option value="V" <?= isset($user['suffix']) && $user['suffix'] === 'V' ? 'selected' : '' ?>>V</option>
                                                            <option value="Ph.D" <?= isset($user['suffix']) && $user['suffix'] === 'Ph.D' ? 'selected' : '' ?>>Ph.D</option>
                                                            <option value="MD" <?= isset($user['suffix']) && $user['suffix'] === 'MD' ? 'selected' : '' ?>>MD</option>
                                                            <option value="DDS" <?= isset($user['suffix']) && $user['suffix'] === 'DDS' ? 'selected' : '' ?>>DDS</option>
                                                            <option value="Esq." <?= isset($user['suffix']) && $user['suffix'] === 'Esq.' ? 'selected' : '' ?>>Esq.</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label for="sex">Sex</label>
                                                        <select class="form-control" id="sex" name="sex">
                                                            <option value="Male" <?= isset($user['sex']) && $user['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                                            <option value="Female" <?= isset($user['sex']) && $user['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="province_<?= $user['id'] ?>">Province</label>
                                                        <select class="form-control" id="province_<?= $user['id'] ?>" name="province">
                                                            <option value=""><?= $user['province'] ?? '' ?></option>
                                                            <?php foreach ($locations as $province => $municipalities): ?>
                                                                <option value="<?= $province ?>" <?= isset($user['province']) && $user['province'] === $province ? 'selected' : '' ?>><?= $province ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label for="municipality_<?= $user['id'] ?>">Municipality</label>
                                                        <select class="form-control" id="municipality_<?= $user['id'] ?>" name="municipality">
                                                            <option value=""><?= $user['municipality'] ?? '' ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="barangay_<?= $user['id'] ?>">Barangay</label>
                                                        <select class="form-control" id="barangay_<?= $user['id'] ?>" name="barangay">
                                                            <option value=""><?= $user['barangay'] ?? '' ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label for="civil_status">Civil Status</label>
                                                        <select class="form-control" id="civil_status" name="civil_status">
                                                            <option value="single" <?= isset($user['civil_status']) && $user['civil_status'] === 'single' ? 'selected' : '' ?>>Single</option>
                                                            <option value="married" <?= isset($user['civil_status']) && $user['civil_status'] === 'married' ? 'selected' : '' ?>>Married</option>
                                                            <option value="widowed" <?= isset($user['civil_status']) && $user['civil_status'] === 'widowed' ? 'selected' : '' ?>>Widowed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="position">Position</label>
                                                        <input type="text" class="form-control" id="position" name="position" value="<?= $user['position'] ?? '' ?>">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?? '' ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="contact_no">Contact Number</label>
                                                        <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?= $user['contact_no'] ?? '' ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-end mt-4">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </div>
                                            </div>
                                        </form>

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
      


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Staff</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="../backendAdmin/add_staff.php">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="firstname">First Name</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="col-md-6">
                            <label for="middlename">Middle Name</label>
                            <input type="text" class="form-control" id="middlename" name="middlename">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                        <div class="col-md-6">
                            <label for="suffix">Suffix</label>
                            <select class="form-control" id="suffix" name="suffix">
                              <option value="">Select Suffix</option>
                              <option value="Jr.">Jr.</option>
                              <option value="Sr.">Sr.</option>
                              <option value="I">I</option>
                              <option value="II">II</option>
                              <option value="III">III</option>
                              <option value="IV">IV</option>
                              <option value="V">V</option>
                              <option value="Ph.D">Ph.D</option>
                              <option value="MD">MD</option>
                              <option value="DDS">DDS</option>
                              <option value="Esq.">Esq.</option>
                          </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="sex">Sex</label>
                            <select class="form-control" id="sex" name="sex">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="province">Province</label>
                            <select class="form-control mr-2" id="addprovince" name="province">
                                <option value="" disabled selected></option>
                                <?php foreach ($locations as $province => $municipalities): ?>
                                    <option value="<?= $province ?>"><?= $province ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="municipality">Municipality</label>
                            <select class="form-control mr-2" id="addmunicipality" name="municipality">
                                <option value="" disabled selected></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="barangay">Barangay</label>
                            <select class="form-control" id="addbarangay" name="barangay">
                                <option value="" disabled selected></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="civil_status">Civil Status</label>
                            <select class="form-control" id="civil_status" name="civil_status">
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="position">Position</label>
                            <input type="text" class="form-control" id="position" name="position">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="contact_no">Contact Number</label>
                            <input type="text" class="form-control" id="contact_no" name="contact_no">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end mt-4">
                        <button type="submit" class="btn btn-success">Add</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>


    </section>
  </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

<script>
    function deleteUser(userId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                window.location.href = '../backendAdmin/delete_staff.php?id=' + userId;
            }
        });
    }
</script>

<script>
$(document).ready(function() {
    $('#name').on('input', function() {
        let name = $(this).val();
        $.ajax({
            url: '../backendAdmin/check_user.php',
            type: 'POST',
            data: { name: name },
            success: function(response) {
                let data = JSON.parse(response);
                if (data.name_error) {
                    $('#name-error').text(data.name_error).show();
                    $('#addUser-btn').prop('disabled', true);
                } else {
                    $('#name-error').text('').hide();
                    if (!$('#name-error').text()) {
                        $('#addUser-btn').prop('disabled', false);
                    }
                }
            }
        });
    });

    $('#email').on('input', function() {
        let email = $(this).val();
        $.ajax({
            url: '../backendAdmin/check_user.php',
            type: 'POST',
            data: { email: email },
            success: function(response) {
                let data = JSON.parse(response);
                if (data.email_error) {
                    $('#email-error').text(data.email_error).show();
                    $('#addUser-btn').prop('disabled', true);
                } else {
                    $('#email-error').text('').hide();
                    if (!$('#email-error').text()) {
                        $('#addUser-btn').prop('disabled', false);
                    }
                }
            }
        });
    });
});
</script>

<script>
document.querySelectorAll('[id^="province_"]').forEach(function (provinceSelect) {
    provinceSelect.addEventListener('change', function () {
        const province = this.value;
        const rowId = this.id.split('_')[1]; // Extract the unique row ID
        const municipalitySelect = document.getElementById('municipality_' + rowId);
        const barangaySelect = document.getElementById('barangay_' + rowId);

        municipalitySelect.innerHTML = '<option value="" disabled selected>Select Municipality</option>';
        barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

        if (province) {
            const municipalities = <?php echo json_encode($locations); ?>[province];

            municipalitySelect.innerHTML = '<option value="" disabled selected>Select Municipality</option>';

            for (const municipality in municipalities) {
                municipalitySelect.innerHTML += `<option value="${municipality}">${municipality}</option>`;
            }
        }
    });
});

document.querySelectorAll('[id^="municipality_"]').forEach(function (municipalitySelect) {
    municipalitySelect.addEventListener('change', function () {
        const rowId = this.id.split('_')[1]; // Extract the unique row ID
        const province = document.getElementById('province_' + rowId).value;
        const municipality = this.value;
        const barangaySelect = document.getElementById('barangay_' + rowId);

        barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

        if (province && municipality) {
            const barangays = <?php echo json_encode($locations); ?>[province][municipality];

            barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

            barangays.forEach(function (barangay) {
                barangaySelect.innerHTML += `<option value="${barangay}">${barangay}</option>`;
            });
        }
    });
});


</script>


<script>
    document.getElementById('addprovince').addEventListener('change', function () {
        const province = this.value;
        const municipalitySelect = document.getElementById('addmunicipality');
        const barangaySelect = document.getElementById('addbarangay');

        municipalitySelect.innerHTML = '<option value="" disabled selected>Select Municipality</option>';
        barangaySelect.innerHTML = '<option value="" disabled selected>Select Barangay</option>';

        if (province) {
            const municipalities = <?php echo json_encode($locations); ?>[province];
            for (const municipality in municipalities) {
                municipalitySelect.innerHTML += `<option value="${municipality}">${municipality}</option>`;
            }
        }
    });

    document.getElementById('addmunicipality').addEventListener('change', function () {
        const province = document.getElementById('addprovince').value;
        const municipality = this.value;
        const barangaySelect = document.getElementById('addbarangay');

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
include('../adminpage/footer.php');
?>