<form id="addpatient" action="../api/api_user.php" method="post">
  <div id="addEmpModal" class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Add Patients</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- First Row -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="last_name">Last Name<span class="h5 text-danger">*</span></label>
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
            </div>
            <div class="form-group col-md-4">
              <label for="first_name">First Name<span class="h5 text-danger">*</span></label>
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
            </div>
            <div class="form-group col-md-4">
              <label for="middle_name">Middle Name</label>
              <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter middle name">
            </div>
          </div>

          <!-- Second Row -->
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
              <label for="municipality_id">Municipality</label>
              <select class="form-control" id="municipality_id" name="municipality_id" required>
                <option value="" disabled selected>Select Municipality</option>
                <option value="1">Calapan City</option>
                <option value="2">Naujan</option>
                <option value="3">Baco</option>
                <option value="4">San Teodoro</option>
                <option value="5">Puerto Galera</option>
                <option value="6">Victoria</option>
                <option value="7">Socorro</option>
                <option value="8">Pola</option>
                <option value="9">Pinamalayan</option>
                <option value="10">Bongabong</option>
                <option value="11">Gloria</option>
                <option value="12">Bansud</option>
                <option value="13">Roxas</option>
                <option value="14">Mansalay</option>
                <option value="15">Bulalacao</option>
                <option value="16">San Jose Occidental</option>
                <option value="16">Mamburao Occidental</option>
              </select>
</div>
           
            <div class="form-row">
            <div class="form-group col-md-4">
              <label for="contact_number">Contact Number</label>
              <input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Enter contact number">
             </div>

            <div class="form-group col-md-4">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
             </div>

            <div class="form-group col-md-4">
              <label for="address">Address</label>
              <textarea class="form-control" id="address" name="address" placeholder="Enter address"></textarea>
            </div>
                      
                  
                    
            <div class="form-row"> 
            <div class="form-group col-md-4">
              <label for="city">City</label>
              <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
            </div>

             <div class="form-group col-md-4">
              <label for="state">Province</label>
              <input type="text" class="form-control" id="state" name="state" placeholder="Enter province">
            </div>
        
            <div class="form-group col-md-4">
              <label for="postal_code">Postal Code</label>
              <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter postal code">
            </div>
     
        
            <div class="form-group col-md-4">
            <label for="medical_history">Medical History</label>
            <textarea class="form-control" id="medical_history" name="medical_history" placeholder="Enter medical history"></textarea>
          </div>
          </div>
       
          <div class="form-group col-md-4">
              
              </div>
              <div class="form-group col-md-4">
                
              </div>
            </div>
          </div> <!--modal-body-->
  
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </form>
   