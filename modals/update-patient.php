<form id="updatePatientForm" action="../api/api_patient.php" method="post">
  <input type="hidden" id="patient_id" name="id" value="0">
  <div id="updatePatientModal" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Update Patient</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <div class="col-12 text-right text-danger">
              <label><i>* Denotes Required Field</i></label>
            </div>
          </div>

          <!-- Basic Information -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="first_name">First Name<span class="h5 text-danger">*</span></label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
            </div>
            <div class="form-group col-md-4">
              <label for="last_name">Last Name<span class="h5 text-danger">*</span></label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
            </div>
            <div class="form-group col-md-4">
              <label for="middle_name">Middle Name</label>
              <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter middle name">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="date_of_birth">Date of Birth<span class="h5 text-danger">*</span></label>
              <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="form-group col-md-4">
              <label for="gender">Gender<span class="h5 text-danger">*</span></label>
              <select class="form-control" id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="municipality_id">Municipality ID<span class="h5 text-danger">*</span></label>
              <input type="text" class="form-control" id="municipality_id" name="municipality_id" placeholder="Enter municipality ID" required>
            </div>
          </div>

          <!-- Contact Information -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="contact_number">Contact Number</label>
              <input type="tel" class="form-control" id="contact_number" name="contact_number" placeholder="Enter contact number" pattern="[0-9]{10}" title="Enter a valid 10-digit phone number">
            </div>
            <div class="form-group col-md-4">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
          </div>

          <!-- Address -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="address">Address</label>
              <textarea class="form-control" id="address" name="address" placeholder="Enter address"></textarea>
            </div>
            <div class="form-group col-md-4">
              <label for="city">City</label>
              <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
            </div>
            <div class="form-group col-md-4">
              <label for="state">State</label>
              <input type="text" class="form-control" id="state" name="state" placeholder="Enter state">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="postal_code">Postal Code</label>
              <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter postal code">
            </div>
          </div>

          <!-- Medical Information -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="medical_history">Medical History</label>
              <textarea class="form-control" id="medical_history" name="medical_history" placeholder="Enter medical history"></textarea>
            </div>
            <div class="form-group col-md-6">
              <label for="allergies">Allergies</label>
              <textarea class="form-control" id="allergies" name="allergies" placeholder="Enter allergies"></textarea>
            </div>
          </div>

          <!-- Boolean Fields -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="tendency_to_bleed">Tendency to Bleed</label>
              <select class="form-control" id="tendency_to_bleed" name="tendency_to_bleed" required>
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="high_blood_pressure">High Blood Pressure</label>
              <select class="form-control" id="high_blood_pressure" name="high_blood_pressure" required>
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="diabetic">Diabetic</label>
              <select class="form-control" id="diabetic" name="diabetic" required>
                <option value="yes">Yes</option>
                <option value="no">No</option>
              </select>
            </div>
          </div>

          <!-- Thyroid Information -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="t3_level">T3 Level</label>
              <select class="form-control" id="t3_level" name="t3_level" required>
                <option value="">Select T3 Level</option>
                <option value="Low">Low</option>
                <option value="Normal">Normal</option>
                <option value="High">High</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="t4_level">T4 Level</label>
              <select class="form-control" id="t4_level" name="t4_level" required>
                <option value="">Select T4 Level</option>
                <option value="Low">Low</option>
                <option value="Normal">Normal</option>
                <option value="High">High</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="tsh_level">TSH Level</label>
              <select class="form-control" id="tsh_level" name="tsh_level" required>
                <option value="">Select TSH Level</option>
                <option value="Low">Low</option>
                <option value="Normal">Normal</option>
                <option value="High">High</option>
              </select>
            </div>
          </div>

          <!-- Symptoms -->
          <div class="form-group">
            <label for="symptoms">Symptoms</label>
            <textarea class="form-control" id="symptoms" name="symptoms" placeholder="Enter symptoms"></textarea>
          </div>
          
          <!-- Notes -->
          <div class="form-group">
            <label for="additional_notes">Additional Notes</label>
            <textarea class="form-control" id="additional_notes" name="additional_notes" placeholder="Enter any additional notes"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
