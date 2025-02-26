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

$sql = "SELECT * FROM appointments WHERE status = 'Approved'";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $appointments = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<style>
    .preload {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>
<div id="preload" class="preload">
    <div class="spinner"></div>
</div>

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
            <h3 class="card-title">Approved Appointments</h3>
            </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Online or Walk In ID</th>
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
                            <td><?php echo $appointment['walkIn_id']; ?><?php echo $appointment['appointment_id']; ?></td>

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
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#showModal<?php echo $appointment['id']; ?>">
                                    <i class="fas fa-check"></i> 
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="showModal<?php echo $appointment['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="showModalLabel<?php echo $appointment['id']; ?>" aria-hidden="true" data-current-page="1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="modal-page-header-<?php echo $appointment['id']; ?>">Personal Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="appointment-form-<?php echo $appointment['id']; ?>" method="POST" action="../backendAdmin/for_payment.php" enctype="multipart/form-data">
                                            <!-- Page 1 Content -->
                                            <div class="tab-content">
                                            <div class="tab-pane fade show active" id="page1-<?php echo $appointment['id']; ?>" role="tabpanel">
                                                <!-- Form content for Page 1 -->
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="family_name">Family Name</label>
                                                            <input type="hidden" id="id-<?php echo $appointment['id']; ?>"name="id" value="<?php echo $appointment['id']; ?>">

                                                            <input type="hidden"  id="user_id-<?php echo $appointment['id']; ?>" name="user_id" value="<?php echo htmlspecialchars($appointment['user_id']); ?>">
                                                            <input type="hidden"  id="patient_id-<?php echo $appointment['id']; ?>" name="patient_id" value="<?php echo htmlspecialchars($appointment['patient_id']); ?>">
                                                            <input type="hidden"  id="appoint_id-<?php echo $appointment['id']; ?>" name="appoint_id" value="<?php echo htmlspecialchars($appointment['appointment_id']); ?>">



                                                            <input type="text" class="form-control" id="family_name-<?php echo $appointment['id']; ?>" name="family_name" value="<?php echo $appointment['family_name']; ?>">
                                                            <!-- Repeat for each field, appending the appointment ID to the ID of each field -->

                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="middle_name">Middle Name</label>
                                                            <input type="text" class="form-control" id="middle_name-<?php echo $appointment['id']; ?>" name="middle_name" value="<?php echo $appointment['middle_name']; ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="given_name">Given Name</label>
                                                            <input type="text" class="form-control" id="given_name-<?php echo $appointment['id']; ?>" name="given_name" value="<?php echo htmlspecialchars($appointment['given_name']); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="suffix">Suffix</label>
                                                            <input type="text" class="form-control" id="suffix-<?php echo $appointment['id']; ?>" name="suffix" value="<?php echo htmlspecialchars($appointment['suffix']); ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="date_of_birth">Date of Birth</label>
                                                            <input type="date" class="form-control" id="date_of_birth-<?php echo $appointment['id']; ?>" name="date_of_birth" value="<?php echo htmlspecialchars($appointment['date_of_birth']); ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="gender">Gender</label>
                                                            <select class="form-control" id="gender-<?php echo $appointment['id']; ?>" name="gender">
                                                                <option value="Male" <?php echo $appointment['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                                                <option value="Female" <?php echo $appointment['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="province">Province</label>
                                                            <input type="text" class="form-control" id="province-<?php echo $appointment['id']; ?>" name="province" value="<?php echo htmlspecialchars($appointment['province']); ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="municipality">Municipality</label>
                                                            <input type="text" class="form-control" id="municipality-<?php echo $appointment['id']; ?>" name="municipality" value="<?php echo htmlspecialchars($appointment['municipality']); ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="barangay">Barangay</label>
                                                            <input type="text" class="form-control" id="barangay-<?php echo $appointment['id']; ?>" name="barangay" value="<?php echo htmlspecialchars($appointment['barangay']); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="contact_number">Contact Number</label>
                                                            <input type="text" class="form-control" id="contact_number-<?php echo $appointment['id']; ?>" name="contact_number" value="<?php echo htmlspecialchars($appointment['contact_number']); ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" id="email-<?php echo $appointment['id']; ?>" name="email" value="<?php echo htmlspecialchars($appointment['email']); ?>">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="postal_code">Postal Code</label>
                                                            <input type="text" class="form-control" id="postal_code-<?php echo $appointment['id']; ?>" name="postal_code" value="<?php echo htmlspecialchars($appointment['postal_code']); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="allergies">Allergies</label>
                                                            <input type="text" class="form-control" id="allergies-<?php echo $appointment['id']; ?>" value="<?php echo $appointment['allergies']; ?>" name="allergies" >
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="heart_disease">Heart Disease</label>
                                                            <input type="text" class="form-control" id="heart_disease-<?php echo $appointment['id']; ?>" name="heart_disease" value="<?php echo $appointment['heart_disease']; ?>" >
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="any_accident">Any Accident</label>
                                                            <input type="text" class="form-control" id="any_accident-<?php echo $appointment['id']; ?>" name="any_accident" value="<?php echo $appointment['any_accident']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="cond_med">Current Condition or Medications</label>
                                                            <textarea class="form-control"id="cond_med-<?php echo $appointment['id']; ?>" name="cond_med" rows="3"><?php echo $appointment['cond_med']; ?></textarea>

                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="any_surgery">Any Surgery</label>
                                                            <textarea class="form-control" id="any_surgery-<?php echo $appointment['id']; ?>" name="any_surgery" rows="3"><?php echo $appointment['any_surgery']; ?></textarea>

                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="medical_history">Medical History</label>
                                                            <textarea class="form-control" id="medical_history-<?php echo $appointment['id']; ?>" name="medical_history" rows="3"><?php echo $appointment['medical_history']; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="image">Lab Results Image</label>
                                                            <input type="file" class="form-control" id="image-<?php echo $appointment['id']; ?>" name="image" >
                                                        </div>
                                                    </div>
                                                        
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="page2-<?php echo $appointment['id']; ?>" role="tabpanel">
                                                <!-- Content for Page 2 -->
                                                <div class="row">
                                                    <!-- Current Condition or Medications -->
                                                    <div class="col-md-4">
                                                        <label for="heart_pulse">Heart Rate (pulse)</label>
                                                        <input type="text" class="form-control" id="heart_pulse-<?php echo $appointment['id']; ?>" name="heart_pulse">
                                                    </div>

                                                    <!-- Oxygen Saturation -->
                                                    <div class="col-md-4">
                                                        <label for="tendency_bleed">Tendency to Bleed</label>
                                                        <input type="text" class="form-control" id="tendency_bleed-<?php echo $appointment['id']; ?>" name="tendency_bleed" >
                                                    </div>

                                                    <!-- Additional Input -->
                                                    <div class="col-md-4">
                                                        <label for="diabetic">Diabetic</label>
                                                        <input type="text" class="form-control" id="diabetic-<?php echo $appointment['id']; ?>" name="diabetic" >
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <!-- Current Condition or Medications -->
                                                    <div class="col-md-4">
                                                        <label for="oxg_saturation">Oxygen saturation</label>
                                                        <input type="text" class="form-control" id="oxg_saturation-<?php echo $appointment['id']; ?>" name="oxg_saturation" >
                                                    </div>

                                                    <!-- Oxygen Saturation -->
                                                    <div class="col-md-4">
                                                        <label for="symptoms">Symptoms</label>
                                                        <input type="text" class="form-control" id="symptoms-<?php echo $appointment['id']; ?>" name="symptoms" >
                                                    </div>

                                                    <!-- Additional Input -->
                                                    <div class="col-md-4">
                                                        <label for="temp">Temperature</label>
                                                        <input type="text" class="form-control" id="temp-<?php echo $appointment['id']; ?>" name="temp">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Current Condition or Medications -->
                                                    <div class="col-md-4">
                                                        <label for="height">Height </label>
                                                        <input type="text" class="form-control" id="height-<?php echo $appointment['id']; ?>" name="height">
                                                    </div>

                                                    <!-- Oxygen Saturation -->
                                                    <div class="col-md-4">
                                                        <label for="blood_pressure">Blood Pressure</label>
                                                        <input type="text" class="form-control" id="blood_pressure-<?php echo $appointment['id']; ?>" name="blood_pressure">
                                                    </div>

                                                    <!-- Additional Input -->
                                                    <div class="col-md-4">
                                                        <label for="weight">Weight </label>
                                                        <input type="text" class="form-control" id="weight-<?php echo $appointment['id']; ?>" name="weight">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Current Condition or Medications -->
                                                    <div class="col-md-4">
                                                        <label for="sugar_rate">Sugar Rate</label>
                                                        <input type="text" class="form-control" id="sugar_rate-<?php echo $appointment['id']; ?>" name="sugar_rate">
                                                    </div>

                                                    <!-- Oxygen Saturation -->
                                                    <div class="col-md-4">
                                                        <label for="family_med_history">Family Medical History</label>
                                                        <input type="text" class="form-control" id="family_med_history-<?php echo $appointment['id']; ?>" name="family_med_history" >
                                                    </div>

                                                    <!-- Additional Input -->
                                                    <div class="col-md-4">
                                                        <label for="respiratory_rate">Respiratory Rate</label>
                                                        <input type="text" class="form-control" id="respiratory_rate-<?php echo $appointment['id']; ?>" name="respiratory_rate">
                                                    </div>
                                                </div>

                                            </div>



                                            <div class="tab-pane fade" id="page3-<?php echo $appointment['id']; ?>" role="tabpanel">
                                                <!-- Content for Page 3 -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="t_level">Level Type</label>
                                                        <select class="form-control" id="t_level-<?php echo $appointment['id']; ?>" name="t_level">
                                                            <option value="T3">T3 Level</option>
                                                            <option value="T4">T4 Level</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="tsh_level">TSH Level</label>
                                                        <input type="text" class="form-control" id="tsh_level-<?php echo $appointment['id']; ?>" name="tsh_level" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="known_thyroid_conditions">Known Thyroid Conditions</label>
                                                        <input type="text" class="form-control" id="known_thyroid_conditions-<?php echo $appointment['id']; ?>" name="known_thyroid_conditions" >
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="thyroid_cond_desc">Thyroid Condition Description</label>
                                                        <input type="text" class="form-control" id="thyroid_cond_desc-<?php echo $appointment['id']; ?>" name="thyroid_cond_desc" >
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="current_thy_med">Current Thyroid Medications</label>
                                                        <input type="text" class="form-control" id="current_thy_med-<?php echo $appointment['id']; ?>" name="current_thy_med" >
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="tab-pane fade" id="page4-<?php echo $appointment['id']; ?>" role="tabpanel">
                                                <!-- Content for Page 4 -->
                                                <div class="search-box position-relative">
                                                    <form action="/search" method="GET">
                                                        <input 
                                                            type="text" 
                                                            id="medicineSearch" 
                                                            name="query" 
                                                            class="form-control" 
                                                            placeholder="Search medicine..." 
                                                            aria-label="Search"
                                                        >
                                                        <div id="suggestions" class="dropdown-menu"></div>
                                                    </form>
                                                </div>
                                                <div id="medicine-table-container-<?php echo $appointment['id']; ?>"></div>
                                            </div>

                                            
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" id="back-btn-<?php echo $appointment['id']; ?>" onclick="changePage('prev', <?php echo $appointment['id']; ?>)" disabled>Back</button>
                                        <button type="button" class="btn btn-primary" id="next-btn-<?php echo $appointment['id']; ?>" onclick="changePage('next', <?php echo $appointment['id']; ?>)">Next</button>
                                        <button type="button" class="btn btn-success" id="process-btn-<?php echo $appointment['id']; ?>" style="display:none;" onclick="submitForm(<?php echo $appointment['id']; ?>)">Process</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>

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
  <!-- /.content-wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tab-pane').forEach(tabPane => {
        const appointmentId = tabPane.id.split('-')[1]; 
        const searchInput = tabPane.querySelector('.search-box #medicineSearch');
        const suggestionsBox = tabPane.querySelector('.search-box #suggestions');
        const tableContainer = tabPane.querySelector(`#medicine-table-container-${appointmentId}`);

        if (!searchInput || !suggestionsBox || !tableContainer) return;

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim();

            if (query.length > 1) { 
                fetch(`../backendAdmin/fetch_medicine.php?term=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionsBox.innerHTML = '';

                        if (data.length > 0) {
                            suggestionsBox.classList.add('show');
                            data.forEach(item => {
                                const suggestion = document.createElement('a');
                                suggestion.className = 'dropdown-item';
                                suggestion.textContent = `${item.brand_name} - ${item.medicine_name}, ${item.dosage} (${item.gram}g) ${item.expiry_date}`;
                                suggestion.onclick = () => {
                                    searchInput.value = ''; 
                                    suggestionsBox.classList.remove('show');
                                    addMedicineRow(item, appointmentId); 
                                };
                                suggestionsBox.appendChild(suggestion);
                            });
                        } else {
                            suggestionsBox.classList.remove('show');
                        }
                    })
                    .catch(error => console.error('Error fetching suggestions:', error));
            } else {
                suggestionsBox.classList.remove('show');
            }
        });

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.remove('show');
            }
        });

        function addMedicineRow(medicine, appointmentId) {
            const { brand_name, medicine_name, dosage, gram, price_unit, id, stock_qty } = medicine;

            const existingRow = Array.from(tableContainer.querySelectorAll('tr')).some(row => {
                const rowId = row.querySelector('.medicine-id');
                return rowId && rowId.value === id;
            });

            if (existingRow) {
                alert("This medicine is already added.");
                return; 
            }

            if (tableContainer.innerHTML === '') {
                tableContainer.innerHTML = `
                    <table class="table table-bordered" id="medicine-table-${appointmentId}">
                        <thead>
                            <tr>
                                <th>Brand</th>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Gram</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="medicine-table-body-${appointmentId}">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right"><strong>Total:</strong></td>
                                <td id="total-price-${appointmentId}" colspan="2"><strong>0.00</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                `;
            }

            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <input type="hidden" class="medicine-id" value="${id}">
                <td><input type="text" class="form-control medicine-brand" value="${brand_name}" readonly></td>
                <td><input type="text" class="form-control medicine-name" value="${medicine_name}" readonly></td>
                <td><input type="text" class="form-control medicine-dosage" value="${dosage}" readonly></td>
                <td><input type="text" class="form-control medicine-gram" value="${gram}" readonly></td>
                <td><input type="text" class="form-control medicine-price" value="${price_unit}" readonly></td>
                <td><input type="number" class="form-control medicine-quantity" value="0" min="0" max="${stock_qty}"></td>
                <td><input type="text" class="form-control medicine-total" value="0" readonly></td>
                <td><button type="button" class="btn btn-danger remove-btn">X</button></td>
            `;

            tabPane.querySelector(`#medicine-table-body-${appointmentId}`).appendChild(newRow);
            updateTotal(newRow.querySelector('.medicine-quantity'), appointmentId); 

            newRow.querySelector('.medicine-quantity').addEventListener('input', function () {
                const quantity = parseFloat(this.value);
                if (quantity > stock_qty) {
                    alert(`Out of stocks! The current stock for this medicine is ${stock_qty}.`);
                    this.value = stock_qty; 
                }
                updateTotal(this, appointmentId);
            });

            newRow.querySelector('.remove-btn').addEventListener('click', function () {
                removeRow(newRow, appointmentId);
            });

            updateFooterTotal(appointmentId);
        }

        function updateTotal(inputElement, appointmentId) {
            const row = inputElement.closest('tr');
            const quantity = parseFloat(inputElement.value) || 0;
            const price = parseFloat(row.querySelector('.medicine-price').value) || 0;
            const total = row.querySelector('.medicine-total');

            total.value = (quantity * price).toFixed(2);

            updateFooterTotal(appointmentId);
        }

        function removeRow(row, appointmentId) {
            row.remove();
            if (tabPane.querySelector(`#medicine-table-body-${appointmentId}`).children.length === 0) {
                tableContainer.innerHTML = ''; 
            } else {
                updateFooterTotal(appointmentId); 
            }
        }

        function updateFooterTotal(appointmentId) {
            const allRows = tabPane.querySelectorAll(`#medicine-table-body-${appointmentId} tr`);
            let totalSum = 0;

            allRows.forEach(row => {
                const rowTotal = parseFloat(row.querySelector('.medicine-total').value) || 0;
                totalSum += rowTotal;
            });
            tabPane.querySelector(`#total-price-${appointmentId}`).innerHTML = `<strong>${totalSum.toFixed(2)}</strong>`;
        }
    });
});

</script>



<script>
function changePage(direction, appointmentId) {
    const totalPages = 4;
    const pageHeaders = [
        "Personal Details",
        "Checkup Details",
        "Lab Test Details",
        "Prescription",
    ];

    let currentPage = parseInt(
        document.querySelector(`#showModal${appointmentId}`).dataset.currentPage || "1"
    );

    if (direction === 'next' && currentPage < totalPages) {
        currentPage++;
    } else if (direction === 'prev' && currentPage > 1) {
        currentPage--;
    }

    document.querySelector(`#showModal${appointmentId}`).dataset.currentPage = currentPage;

    document.getElementById(`modal-page-header-${appointmentId}`).textContent = pageHeaders[currentPage - 1];

    for (let i = 1; i <= totalPages; i++) {
        const pageElement = document.getElementById(`page${i}-${appointmentId}`);
        if (pageElement) {
            pageElement.classList.remove('show', 'active');
        }
    }
    document.getElementById(`page${currentPage}-${appointmentId}`).classList.add('show', 'active');

    document.getElementById(`back-btn-${appointmentId}`).disabled = currentPage === 1;
    document.getElementById(`next-btn-${appointmentId}`).style.display =
        currentPage === totalPages ? 'none' : 'inline-block';

    const processButton = document.getElementById(`process-btn-${appointmentId}`);
    processButton.style.display = currentPage === totalPages ? 'inline-block' : 'none';
}

$(document).on('shown.bs.modal', function (e) {
    const modalId = e.target.id;
    const appointmentId = modalId.replace("showModal", "");
    document.querySelector(`#${modalId}`).dataset.currentPage = "1"; // Reset page state
    changePage('next', appointmentId); 
});

function submitForm(appointmentId) {
    const form = document.querySelector(`#appointment-form-${appointmentId}`);
    if (form) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to process on payment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {

                const medicineRows = document.querySelectorAll(`#medicine-table-body-${appointmentId} tr`);
                const medicines = [];

                medicineRows.forEach(row => {
                    const medicineId = row.querySelector('.medicine-id').value;
                    const brandName = row.querySelector('.medicine-brand').value;
                    const medicineName = row.querySelector('.medicine-name').value;
                    const dosage = row.querySelector('.medicine-dosage').value;
                    const gram = row.querySelector('.medicine-gram').value;
                    const priceUnit = row.querySelector('.medicine-price').value;
                    const quantity = row.querySelector('.medicine-quantity').value;

                    medicines.push({
                        id: medicineId,
                        brand_name: brandName,
                        medicine_name: medicineName,
                        dosage: dosage,
                        gram: gram,
                        price_unit: priceUnit,
                        quantity: quantity
                    });
                });

                const medicinesInput = document.createElement("input");
                medicinesInput.type = "hidden";
                medicinesInput.name = "medicines";
                medicinesInput.value = JSON.stringify(medicines); 
                form.appendChild(medicinesInput);

                const currentPageInput = document.createElement("input");
                currentPageInput.type = "hidden";
                currentPageInput.name = "current_page";
                currentPageInput.value = "4"; 
                form.appendChild(currentPageInput);

                form.submit();
            }
        });
    }
}
</script>
<script>
    window.addEventListener('load', function() {
    document.getElementById('preload').style.display = 'none';
});
</script>
  
<?php
include('../adminpage/footer.php');
?>