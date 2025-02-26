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
include('../userpage/locations.php');
require '../userLogin/db_con.php';

$current_date = date('Y-m-d'); 

$sql = "SELECT * FROM appointments WHERE status = 'Completed' AND date_completed = :current_date";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
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
            <h3 class="card-title">Completed Online and Walk In Appointments</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#showModal" style="margin-left: auto;">
                + Appointment
            </button>
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
                                $time_from = isset($appointment['time_from']) && !empty($appointment['time_from']) 
                                    ? date('h:i A', strtotime($appointment['time_from'])) 
                                    : '';

                                $time_to = isset($appointment['time_to']) && !empty($appointment['time_to']) 
                                    ? date('h:i A', strtotime($appointment['time_to'])) 
                                    : '';

                                if ($time_from && $time_to) {
                                    echo $time_from . ' - ' . $time_to;
                                } elseif ($time_from) {
                                    echo $time_from;
                                } elseif ($time_to) {
                                    echo $time_to;
                                }
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

    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true" data-current-page="1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-page-header">Personal Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="appointment-form" method="POST" action="../backendAdmin/walkin_forPayment.php" enctype="multipart/form-data">
                        <!-- Page 1 Content -->
                        <div class="tab-content">
                        <div class="tab-pane fade show active" id="page1" role="tabpanel">
                            <!-- Form content for Page 1 -->
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="family_name">User ID</label>
                                        <input type="hidden" id="patient_id" name="patient_id">
                                        <input type="hidden" id="user_id" name="user_id">
                                        <input type="text" id="userIdSearch" name="query" class="form-control" placeholder="Search User ID..." aria-label="Search">
                                        <div id="userID_suggestions" class="dropdown-menu"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="family_name">Family Name</label>
                                        <input type="text" class="form-control" id="family_name" name="family_name" >
                                    </div>

                                    <div class="col-md-4">
                                        <label for="middle_name">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="given_name">Given Name</label>
                                        <input type="text" class="form-control" id="given_name" name="given_name">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="suffix">Suffix</label>
                                        <input type="text" class="form-control" id="suffix" name="suffix">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="date_of_birth">Date of Birth</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="gender">Gender</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="province">Province</label>
                                        <select class="form-control font-italic" id="province" name="province">
                                            <option value="" disabled selected>--- Select ----</option>
                                            <?php foreach ($locations as $provinceKey => $municipalities): ?>
                                                <option value="<?= htmlspecialchars($provinceKey) ?>" <?= (isset($province) && $provinceKey == $province) ? 'selected' : ''; ?>>
                                                    <?= htmlspecialchars($provinceKey) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="municipality">Municipality</label>
                                        <select class="form-control font-italic" id="municipality" name="municipality">
                                            <option value="" disabled selected>--- Select ----</option>
                                            <?php if (isset($province) && isset($locations[$province])): ?>
                                                <?php foreach ($locations[$province] as $municipalityKey => $barangays): ?>
                                                    <option value="<?= htmlspecialchars($municipalityKey) ?>" <?= (isset($municipality) && $municipalityKey == $municipality) ? 'selected' : ''; ?>>
                                                        <?= htmlspecialchars($municipalityKey) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="barangay">Barangay</label>
                                        <select class="form-control font-italic" id="barangay" name="barangay">
                                            <option value="" disabled selected>--- Select ----</option>
                                            <?php if (isset($municipality) && isset($locations[$province][$municipality])): ?>
                                                <?php foreach ($locations[$province][$municipality] as $barangayKey): ?>
                                                    <option value="<?= htmlspecialchars($barangayKey) ?>" <?= (isset($barangay) && $barangayKey == $barangay) ? 'selected' : ''; ?>>
                                                        <?= htmlspecialchars($barangayKey) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="contact_number">Contact Number</label>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="postal_code">Postal Code</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="allergies">Allergies</label>
                                        <input type="text" class="form-control" id="allergies" name="allergies">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="heart_disease">Heart Disease</label>
                                        <input type="text" class="form-control" id="heart_disease" name="heart_disease">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="any_accident">Any Accident</label>
                                        <input type="text" class="form-control" id="any_accident" name="any_accident">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="cond_med">Current Condition or Medications</label>
                                        <textarea class="form-control"id="cond_med" name="cond_med" rows="3"></textarea>

                                    </div>

                                    <div class="col-md-4">
                                        <label for="any_surgery">Any Surgery</label>
                                        <textarea class="form-control" id="any_surgery" name="any_surgery" rows="3"></textarea>

                                    </div>

                                    <div class="col-md-4">
                                        <label for="medical_history">Medical History</label>
                                        <textarea class="form-control" id="medical_history" name="medical_history" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="image">Lab Results Image</label>
                                        <input type="file" class="form-control" id="image" name="image" >
                                    </div>
                                </div>
                                    
                            </div>
                        </div>


                        <div class="tab-pane fade" id="page2" role="tabpanel">
                            <!-- Content for Page 2 -->
                            <div class="row">
                                <!-- Current Condition or Medications -->
                                <div class="col-md-4">
                                    <label for="heart_pulse">Heart Rate (pulse)</label>
                                    <input type="text" class="form-control" id="heart_pulse" name="heart_pulse">
                                </div>

                                <!-- Oxygen Saturation -->
                                <div class="col-md-4">
                                    <label for="tendency_bleed">Tendency to Bleed</label>
                                    <input type="text" class="form-control" id="tendency_bleed" name="tendency_bleed" >
                                </div>

                                <!-- Additional Input -->
                                <div class="col-md-4">
                                    <label for="diabetic">Diabetic</label>
                                    <input type="text" class="form-control" id="diabetic" name="diabetic" >
                                </div>
                            </div>


                            <div class="row">
                                <!-- Current Condition or Medications -->
                                <div class="col-md-4">
                                    <label for="oxg_saturation">Oxygen saturation</label>
                                    <input type="text" class="form-control" id="oxg_saturation" name="oxg_saturation" >
                                </div>

                                <!-- Oxygen Saturation -->
                                <div class="col-md-4">
                                    <label for="symptoms">Symptoms</label>
                                    <input type="text" class="form-control" id="symptoms" name="symptoms" >
                                </div>

                                <!-- Additional Input -->
                                <div class="col-md-4">
                                    <label for="temp">Temperature</label>
                                    <input type="text" class="form-control" id="temp" name="temp">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Current Condition or Medications -->
                                <div class="col-md-4">
                                    <label for="height">Height </label>
                                    <input type="text" class="form-control" id="height" name="height">
                                </div>

                                <!-- Oxygen Saturation -->
                                <div class="col-md-4">
                                    <label for="blood_pressure">Blood Pressure</label>
                                    <input type="text" class="form-control" id="blood_pressure" name="blood_pressure">
                                </div>

                                <!-- Additional Input -->
                                <div class="col-md-4">
                                    <label for="weight">Weight </label>
                                    <input type="text" class="form-control" id="weight" name="weight">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Current Condition or Medications -->
                                <div class="col-md-4">
                                    <label for="sugar_rate">Sugar Rate</label>
                                    <input type="text" class="form-control" id="sugar_rate" name="sugar_rate">
                                </div>

                                <!-- Oxygen Saturation -->
                                <div class="col-md-4">
                                    <label for="family_med_history">Family Medical History</label>
                                    <input type="text" class="form-control" id="family_med_history" name="family_med_history" >
                                </div>

                                <!-- Additional Input -->
                                <div class="col-md-4">
                                    <label for="respiratory_rate">Respiratory Rate</label>
                                    <input type="text" class="form-control" id="respiratory_rate" name="respiratory_rate">
                                </div>
                            </div>

                        </div>



                        <div class="tab-pane fade" id="page3" role="tabpanel">
                            <!-- Content for Page 3 -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="t_level">Level Type</label>
                                    <select class="form-control" id="t_level" name="t_level">
                                        <option value="T3">T3 Level</option>
                                        <option value="T4">T4 Level</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tsh_level">TSH Level</label>
                                    <input type="text" class="form-control" id="tsh_level" name="tsh_level" >
                                </div>
                                <div class="col-md-6">
                                    <label for="known_thyroid_conditions">Known Thyroid Conditions</label>
                                    <input type="text" class="form-control" id="known_thyroid_conditions" name="known_thyroid_conditions" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="thyroid_cond_desc">Thyroid Condition Description</label>
                                    <input type="text" class="form-control" id="thyroid_cond_desc" name="thyroid_cond_desc" >
                                </div>
                                <div class="col-md-6">
                                    <label for="current_thy_med">Current Thyroid Medications</label>
                                    <input type="text" class="form-control" id="current_thy_med" name="current_thy_med" >
                                </div>
                            </div>
                        </div>



                        <div class="tab-pane fade" id="page4" role="tabpanel">
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
                            <div id="medicine-table-container"></div>
                        </div>

                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="back-btn" onclick="changePage('prev',)" disabled>Back</button>
                    <button type="button" class="btn btn-primary" id="next-btn" onclick="changePage('next',)">Next</button>
                    <button type="button" class="btn btn-success" id="process-btn" style="display:none;" onclick="submitForm()">Process</button>
                </div>
            </form>
            </div>
        </div>
    </div>
  </div>
<script>
document.getElementById('userIdSearch').addEventListener('input', function () {
    const query = this.value;
    if (query.length > 0) {
        fetch('../backendAdmin/search_user_id.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'query=' + encodeURIComponent(query)
        })
        .then(response => response.json())
        .then(data => {
            const suggestions = document.getElementById('userID_suggestions');
            suggestions.innerHTML = '';
            suggestions.style.display = 'block';

            if (data.length > 0) {
                data.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'dropdown-item';
                    div.textContent = item.patient_id;
                    div.addEventListener('click', () => {
                        document.getElementById('userIdSearch').value = item.patient_id;
                        document.getElementById('patient_id').value = item.patient_id;
                        suggestions.style.display = 'none';
                        fetchPatientData(item.patient_id);
                    });
                    suggestions.appendChild(div);
                });
            } else {
                suggestions.style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        document.getElementById('userID_suggestions').style.display = 'none';
    }
});

function fetchPatientData(patient_id) {
    fetch('../backendAdmin/fetch_patient_data.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'patient_id=' + encodeURIComponent(patient_id)
    })
    .then(response => response.json())
    .then(data => {
        if (data) {
            document.getElementById('user_id').value = data.id || '';
            document.getElementById('family_name').value = data.family_name || '';
            document.getElementById('middle_name').value = data.middle_name || '';
            document.getElementById('given_name').value = data.given_name || '';
            document.getElementById('suffix').value = data.suffix || '';
            document.getElementById('date_of_birth').value = data.date_of_birth || '';
            document.getElementById('gender').value = data.gender || '';
            document.getElementById('province').value = data.province || '';
            
            document.getElementById('province').dispatchEvent(new Event('change'));

            setTimeout(() => {
                document.getElementById('municipality').value = data.municipality || '';
                
                document.getElementById('municipality').dispatchEvent(new Event('change'));

                setTimeout(() => {
                    document.getElementById('barangay').value = data.barangay || '';
                }, 500); 
            }, 500); 
        }
    })
    .catch(error => console.error('Error fetching patient data:', error));
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tab-pane').forEach(tabPane => {
        const searchInput = tabPane.querySelector('#medicineSearch'); 
        const suggestionsBox = tabPane.querySelector('#suggestions'); 
        const tableContainer = tabPane.querySelector('#medicine-table-container'); 

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
                            
                            const expiryDate = new Date(item.expiry_date);
                            const today = new Date();
                            const expired = expiryDate < today;

                            const expiredText = expired ? 'Expired' : `${item.expiry_date}`;

                            suggestion.textContent = `${item.brand_name} - ${item.medicine_name}, ${item.dosage} (${item.gram}g) ${expiredText}`;
                            suggestion.onclick = () => {
                                searchInput.value = ''; 
                                suggestionsBox.classList.remove('show');
                                addMedicineRow(item); 
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

        function addMedicineRow(medicine) {
            const { brand_name, medicine_name, dosage, gram, price_unit, id, stock_qty, expiry_date } = medicine;

            const existingRow = Array.from(tableContainer.querySelectorAll('tr')).some(row => {
                const rowId = row.querySelector('.medicine-id');
                return rowId && rowId.value === id;
            });

            if (existingRow) {
                alert("This medicine is already added.");
                return;
            }

            const expiryDate = new Date(expiry_date);
            const today = new Date();
            const expired = expiryDate < today;

            if (tableContainer.innerHTML === '') {
                tableContainer.innerHTML = `
                    <table class="table table-bordered">
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
                        <tbody class="medicine-table-body">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6" class="text-right"><strong>Total:</strong></td>
                                <td class="total-price" colspan="2"><strong>0.00</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                `;
            }

            const tableBody = tableContainer.querySelector('.medicine-table-body');

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

            tableBody.appendChild(newRow);
            updateTotal(newRow.querySelector('.medicine-quantity'));

            const quantityInput = newRow.querySelector('.medicine-quantity');
            quantityInput.addEventListener('input', function () {
                const quantity = parseFloat(this.value) || 0;

                if (expired && quantity > 0) {
                    alert("This medicine is expired.");
                    this.value = 0; // Reset the input to 0
                }

                if (quantity > stock_qty) {
                    alert(`Out of stock! The current stock for this medicine is ${stock_qty}.`);
                    this.value = stock_qty;
                }

                updateTotal(this);
            });

            newRow.querySelector('.remove-btn').addEventListener('click', function () {
                removeRow(newRow);
            });

            updateFooterTotal();
        }


        function updateTotal(inputElement) {
            const row = inputElement.closest('tr');
            const quantity = parseFloat(inputElement.value) || 0;
            const price = parseFloat(row.querySelector('.medicine-price').value) || 0;
            const total = row.querySelector('.medicine-total');

            total.value = (quantity * price).toFixed(2);

            updateFooterTotal();
        }

        function removeRow(row) {
            row.remove();
            if (tableContainer.querySelector('.medicine-table-body').children.length === 0) {
                tableContainer.innerHTML = ''; 
            } else {
                updateFooterTotal(); 
            }
        }

        function updateFooterTotal() {
            const allRows = tableContainer.querySelectorAll('.medicine-table-body tr');
            let totalSum = 0;

            allRows.forEach(row => {
                const rowTotal = parseFloat(row.querySelector('.medicine-total').value) || 0;
                totalSum += rowTotal;
            });

            tableContainer.querySelector('.total-price').innerHTML = `<strong>${totalSum.toFixed(2)}</strong>`;
        }
    });
});
</script>


<script>
function changePage(direction) {
    const totalPages = 4;
    const pageHeaders = [
        "Personal Details",
        "Checkup Details",
        "Lab Test Details",
        "Prescription",
    ];

    let currentPage = parseInt(
        document.querySelector(`#showModal`).dataset.currentPage || "1"
    );

    if (direction === 'next' && currentPage < totalPages) {
        currentPage++;
    } else if (direction === 'prev' && currentPage > 1) {
        currentPage--;
    }

    document.querySelector(`#showModal`).dataset.currentPage = currentPage;
    document.getElementById(`modal-page-header`).textContent = pageHeaders[currentPage - 1];

    for (let i = 1; i <= totalPages; i++) {
        const pageElement = document.getElementById(`page${i}`);
        if (pageElement) {
            pageElement.classList.remove('show', 'active');
        }
    }
    document.getElementById(`page${currentPage}`).classList.add('show', 'active');

    document.getElementById(`back-btn`).disabled = currentPage === 1;
    document.getElementById(`next-btn`).style.display =
        currentPage === totalPages ? 'none' : 'inline-block';

    const processButton = document.getElementById(`process-btn`);
    processButton.style.display = currentPage === totalPages ? 'inline-block' : 'none';
}

document.addEventListener('shown.bs.modal', function () {
    document.querySelector(`#showModal`).dataset.currentPage = "1";
    changePage('next');
});

function submitForm() {
    const form = document.querySelector(`#appointment-form`);
    if (!form) return;

    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to proceed with payment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            const medicineRows = document.querySelectorAll(`#medicine-table-container tbody tr`);
            const medicines = [];

            medicineRows.forEach(row => {
                const medicineId = row.querySelector('.medicine-id')?.value;
                const brandName = row.querySelector('.medicine-brand')?.value;
                const medicineName = row.querySelector('.medicine-name')?.value;
                const dosage = row.querySelector('.medicine-dosage')?.value;
                const gram = row.querySelector('.medicine-gram')?.value;
                const priceUnit = row.querySelector('.medicine-price')?.value;
                const quantity = row.querySelector('.medicine-quantity')?.value;

                if (medicineId && brandName && medicineName && dosage && gram && priceUnit && quantity) {
                    medicines.push({
                        id: medicineId,
                        brand_name: brandName,
                        medicine_name: medicineName,
                        dosage: dosage,
                        gram: gram,
                        price_unit: priceUnit,
                        quantity: quantity
                    });
                }
            });

            const existingMedicinesInput = document.querySelector(`input[name="medicines"]`);
            if (existingMedicinesInput) {
                existingMedicinesInput.remove();
            }

            const medicinesInput = document.createElement("input");
            medicinesInput.type = "hidden";
            medicinesInput.name = "medicines";
            medicinesInput.value = JSON.stringify(medicines);
            form.appendChild(medicinesInput);

            form.submit();
        }
    });
}
</script>
<script>
document.getElementById('province').addEventListener('change', function () {
    const province = this.value;
    const municipalitySelect = document.getElementById('municipality');
    const barangaySelect = document.getElementById('barangay');

    municipalitySelect.innerHTML = '<option value="" disabled selected>--- Select ----</option>';
    barangaySelect.innerHTML = '<option value="" disabled selected>--- Select ----</option>';

    if (province) {
        const municipalities = <?php echo json_encode($locations); ?>[province] || {};
        Object.keys(municipalities).forEach(municipality => {
            municipalitySelect.innerHTML += `<option value="${municipality}">${municipality}</option>`;
        });
    }
});

document.getElementById('municipality').addEventListener('change', function () {
    const province = document.getElementById('province').value;
    const municipality = this.value;
    const barangaySelect = document.getElementById('barangay');

    barangaySelect.innerHTML = '<option value="" disabled selected>--- Select ----</option>';

    if (province && municipality) {
        const barangays = <?php echo json_encode($locations); ?>[province][municipality] || [];
        barangays.forEach(barangay => {
            barangaySelect.innerHTML += `<option value="${barangay}">${barangay}</option>`;
        });
    }
});
</script>
<script>
    window.addEventListener('load', function() {
    document.getElementById('preload').style.display = 'none';
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include('../adminpage/footer.php');
?>