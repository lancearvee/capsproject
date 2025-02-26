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
include('../userpage/locations.php');

$current_date = date('Y-m-d');  // Current date in 'YYYY-MM-DD' format

$sql = "SELECT * FROM patient_data";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $patients = $stmt->fetchAll();

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
            <h3 class="card-title">List of Patients</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPatient" style="margin-left: auto;">
                + Patient
            </button>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                        <tr style="border: 2px solid #ccc;">  <!-- Added border for each row -->
                            <td><?php echo $patient['patient_id']; ?></td>

                            <td>
                                <?php
                                echo $patient['given_name'] . ' ' . $patient['middle_name'] . ' ' . $patient['family_name'] . ' ' . $patient['suffix'];
                                ?>
                            </td>
                            <td>
                                <?php
                                // Format the date of birth
                                echo date('F j, Y', strtotime($patient['date_of_birth'])); 
                                ?>
                            </td>
                            <td>
                                <?php
                                echo $patient['province'] . ', ' . $patient['municipality'] . ', ' . $patient['barangay'];
                                ?>
                            </td>
                            <td><?php echo $patient['contact_number']; ?></td>
                            <td><?php echo $patient['email']; ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-<?php echo $patient['id']; ?>" data-user-id="<?php echo $patient['user_id']; ?>">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal for each patient -->
                        <div class="modal fade" id="modal-<?php echo $patient['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modalLabel">Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    
                                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;"> <!-- Make modal scrollable -->
                                        
                                        <!-- Patient Personal Details -->
                                        <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 15px;">
                                            <h5><strong>Patient Information</strong></h5>
                                            <div><strong>Name:</strong> <?php echo $patient['family_name'] . ', ' . $patient['given_name'] . ' ' . $patient['middle_name']; ?></div>
                                            <div><strong>Sex:</strong> <?php echo $patient['gender']; ?></div>
                                            <div><strong>Date of Birth:</strong> <?php echo date('F j, Y', strtotime($patient['date_of_birth'])); ?></div>
                                            <div><strong>Email:</strong> <?php echo $patient['email']; ?></div>
                                            <div><strong>Postal Code:</strong> <?php echo $patient['postal_code']; ?></div>
                                            <div><strong>Latest Medical History:</strong> <?php echo $patient['medical_history']; ?></div>
                                            <div><strong>Heart Disease:</strong> <?php echo $patient['heart_disease']; ?></div>
                                            <div><strong>Latest Accident:</strong> <?php echo $patient['any_accident']; ?></div>
                                            <div><strong>Latest Surgery:</strong> <?php echo $patient['any_surgery']; ?></div>
                                            <div><strong>Allergies:</strong> <?php echo $patient['allergies']; ?></div>
                                            <div><strong>Current Condition or Medications:</strong> <?php echo $patient['cond_med']; ?></div>
                                        </div>

                                        <!-- Fetch and display lab results using user_id -->
                                        <div id="lab-details-<?php echo $patient['id']; ?>" style="border: 1px solid #ddd; padding: 10px;">
                                            <h6><strong>Laboratory Test and Check Up Results</strong></h6>
                                            <div id="lab-content-<?php echo $patient['id']; ?>">Loading lab details...</div>
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

      <div class="modal fade" id="addPatient">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Patient</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="POST" action="../backendAdmin/add_patient.php">
                <div class="container">

                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Username</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                oninput="this.value = this.value.replace(/\s/g, '')" 
                                onblur="checkUserExists('name')">
                            <small id="name-error" class="text-danger"></small>
                        </div>

                        <div class="col-md-4">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                oninput="this.value = this.value.replace(/\s/g, '')" 
                                onblur="checkUserExists('email')">
                            <small id="email-error" class="text-danger"></small>
                        </div>

                        <div class="col-md-4">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" 
                                oninput="this.value = this.value.replace(/\s/g, '')">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="family_name">Family Name</label>
                            <input type="text" class="form-control" name="family_name">
                        </div>

                        <div class="col-md-4">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name">
                        </div>

                        <div class="col-md-4">
                            <label for="given_name">Given Name</label>
                            <input type="text" class="form-control" name="given_name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth">
                        </div>

                        <div class="col-md-4">
                            <label for="gender">Gender</label>
                            <select class="form-control"name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="province">Province</label>
                            <select class="form-control mr-2" id="addprovince" name="province">
                                <option value="" disabled selected></option>
                                <?php foreach ($locations as $province => $municipalities): ?>
                                    <option value="<?= $province ?>"><?= $province ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="municipality">Municipality</label>
                            <select class="form-control mr-2" id="addmunicipality" name="municipality">
                                <option value="" disabled selected></option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="barangay">Barangay</label>
                            <select class="form-control" id="addbarangay" name="barangay">
                                <option value="" disabled selected></option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" pattern="^[0-9]{11}$" maxlength="11" required title="Please enter exactly 11 digits.">
                        </div>

                        <div class="col-md-4">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code">
                        </div>

                        <div class="col-md-4">
                            <label for="allergies">Allergies</label>
                            <input type="text" class="form-control" name="allergies" >
                        </div>
                    </div>

                    <div class="row">
                        

                        <div class="col-md-4">
                            <label for="heart_disease">Heart Disease</label>
                            <input type="text" class="form-control" name="heart_disease" >
                        </div>

                        <div class="col-md-4">
                            <label for="any_accident">Any Accident</label>
                            <input type="text" class="form-control" name="any_accident" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="cond_med">Current Condition or Medications</label>
                            <textarea class="form-control" name="cond_med" rows="3"></textarea>

                        </div>

                        <div class="col-md-4">
                            <label for="any_surgery">Any Surgery</label>
                            <textarea class="form-control"  name="any_surgery" rows="3"></textarea>
                        </div>

                        <div class="col-md-4">
                            <label for="medical_history">Medical History</label>
                            <textarea class="form-control"  name="medical_history" rows="3"></textarea>
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

    

    <!-- Modal for displaying thyroid medication image -->
    <div class="modal fade" id="thyroidModal" tabindex="-1" role="dialog" aria-labelledby="thyroidModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="thyroidModalLabel">Results Image</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="thyroidImage" src="" alt="Thyroid Medication Image" style="width: 100%; height: auto;"/>
                </div>
            </div>
        </div>
    </div>

  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<script>
function checkUserExists(field) {
    let value = document.getElementById(field).value;
    let errorElement = document.getElementById(field + "-error");

    if (value.trim() === "") {
        errorElement.textContent = "";
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../backendAdmin/check_user_add.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.status === "exists") {
                errorElement.textContent = response.message;
            } else {
                errorElement.textContent = "";
            }
        }
    };

    xhr.send("field=" + field + "&value=" + encodeURIComponent(value));
}

    $('#example1').on('click', '[data-toggle="modal"]', function() {
        var userId = $(this).data('user-id');
        var modalId = $(this).data('target');

        $.ajax({
            url: '../backendAdmin/fetch_lab_details.php',
            type: 'GET',
            data: { user_id: userId },
            success: function(response) {
                $('#lab-content-' + modalId.split('-')[1]).html(response);
            },
            error: function() {
                $('#lab-content-' + modalId.split('-')[1]).html('Error loading lab and prescription details.');
            }
        });
    });
</script>

<script>
    $(document).on('click', '.view-thyroid-med', function() {
        var imagePath = $(this).data('image-path');  // Get the image path from the button's data attribute
        $('#thyroidImage').attr('src', imagePath);  // Set the image source to the path
        $('#thyroidModal').modal('show');  // Show the modal
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