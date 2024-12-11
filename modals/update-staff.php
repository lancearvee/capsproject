<form id="viewupdateUserForm" action="../api/api_user.php" method="post">
  <input type="hidden" id="e_user_id" name="user_id" value="0">
  <div id="viewupdateUserModal" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Update Staff</h4>
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

          <!-- First Row -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="e_last_name">Last Name<span class="h5 text-danger">*</span></label>
              <input type="text" class="form-control" id="e_last_name" name="last_name" 
                     placeholder="Enter last name" required 
                     pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed."
                      >
            </div>
            <div class="form-group col-md-4">
              <label for="e_first_name">First Name<span class="h5 text-danger">*</span></label>
              <input type="text" class="form-control" id="e_first_name" name="first_name" 
                     placeholder="Enter first name" required 
                     pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed."
                      >
            </div>
            <div class="form-group col-md-4">
              <label for="e_middle_name">Middle Name</label>
              <input type="text" class="form-control" id="e_middle_name" name="middle_name" 
                     placeholder="Enter middle name" 
                     pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed."
                      >
            </div>
          </div>

          <!-- Second Row -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="e_date_of_birth">Date of Birth<span class="h5 text-danger">*</span></label>
              <input type="date" class="form-control" id="e_date_of_birth" name="date_of_birth" required>
            </div>
            <div class="form-group col-md-4">
              <label for="e_gender">Gender<span class="h5 text-danger">*</span></label>
              <select class="form-control" id="e_gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="e_specialization">Specialization<span class="h5 text-danger">*</span></label>
              <select class="form-control" id="e_specialization" name="specialization" required>  
              <option value="">Select Specialization</option>
                <option value="Nurse">Nurse</option>
                <option value="Physician">Physician</option>
                <option value="Therapist">Therapist</option>
              </select>
            </div>
          </div>

          <!-- Third Row -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="e_contact_number">Contact Number</label>
              <input type="tel" class="form-control" id="e_contact_number" name="contact_number" 
                     placeholder="Enter contact number" pattern="[0-9]{11}" 
                     title="Enter a valid 10-digit phone number">
            </div>
            <div class="form-group col-md-4">
              <label for="e_experience_years">Experience Years<span class="h5 text-danger">*</span></label>
              <input type="number" class="form-control" id="e_experience_years" name="experience_years" 
                     placeholder="Enter years of experience" min="0" required>
            </div>
            <div class="form-group col-md-4">
              <label for="e_availability">Availability</label>
              <select class="form-control" id="e_availability" name="availability" required>
                <option value="Available">Available</option>
                
              </select>
            </div>
          </div>

          <!-- Fourth Row -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="e_email">Email</label>
              <input type="email" class="form-control" id="e_email" name="email" 
                     placeholder="Enter email" required>
            </div>
            <div class="form-group col-md-4">
              <label for="e_address">Address</label>
              <textarea class="form-control" id="e_address" name="address" 
                        placeholder="Enter address"></textarea>
            </div>
            <div class="form-group col-md-4">
              <label for="e_city">City</label>
              <input type="text" class="form-control" id="e_city" name="city" 
                     placeholder="Enter city" required>
            </div>
          </div>

          <!-- Fifth Row -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="e_state">Province</label>
              <input type="text" class="form-control" id="e_state" name="state" 
                     placeholder="Enter state" required>
            </div>
          </div>

        </div> <!--modal-body-->

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

