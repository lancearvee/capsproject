    <div class="modal fade bd-example-modal-lg" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalLabel">Make Appointment</h5><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body p-4">
              <form class="zform" method="post">
                <div class="zform-feedback"></div><input class="form-control" type="hidden" name="to" value="username@domain.extension" />
                <div class="form-row">
                  <div class="form-group col-md-6"><label class="font-weight-bold" for="inputName">Patient name</label><input class="form-control font-italic" id="inputName" type="text" placeholder="Enter full name" name="name" required="required" /></div>
                  <div class="form-group col-md-6"><label class="font-weight-bold">Date of birth*</label>
                    <div class="form-row">
                      <div class="col-4"><select class="custom-select" id="inputDay" name="birthDay" required="required">
                          <option selected="selected">DD</option>
                        </select></div>
                      <div class="col-4"><select class="custom-select" id="inputMonth" name="birthMonth" required="required">
                        </select></div>
                      <div class="col-4"><select class="custom-select" id="inputYear" name="birthYear" required="required">
                        </select></div>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6"><label class="font-weight-bold" for="inputMail">Email</label><input class="form-control font-italic" id="inputMail" type="email" placeholder="Enter Your Enail" aria-describedby="mail" name="email" required="required" /><small class="form-text text-muted" id="mail">We'll never share your email with anyone else.</small></div>
                  <div class="form-group col-md-6"><label class="font-weight-bold" for="inputNumber">Contact number</label><input class="form-control font-italic" id="inputNumber" type="tel" placeholder="Contact number" name="contactNumber" required="required" /></div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6"><label class="font-weight-bold" for="inputDoc">Preferred doctor (if any)</label><input class="form-control font-italic" id="inputDoc" type="text" placeholder="Enter doctor's name" name="preferredDoctor" /></div>
                  <div class="form-group col-md-6"><label class="font-weight-bold" for="inputMedical">At the following hospital</label><select class="custom-select" id="inputMedical" name="hospital">
                      <option selected="">No preference </option>
                      <option>Labaide Hospital</option>
                      <option>Central Hospital</option>
                      <option>Square Hospital</option>
                    </select></div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6"><label class="font-weight-bold" for="inputSpecialty">Specialty</label><select class="custom-select" id="inputSpecialty" name="speciality">
                      <option selected="">I am not sure</option>
                      <option>Labaide Hospital</option>
                      <option>Central Hospital</option>
                      <option>Square Hospital</option>
                    </select></div>
                  <div class="form-group col-md-6"><label class="font-weight-bold" for="inputCode">Reference code (if any)</label><input class="form-control font-italic" id="inputCode" type="number" placeholder="Enter the code" name="referenceCode" /></div>
                </div>
                <div class="form-group"><label class="font-weight-bold" for="inputAddress">Address</label><input class="form-control font-italic" id="inputAddress" type="text" placeholder="Apartment, studio, or floor" name="address" /></div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <div><label class="font-weight-bold">Gender</label></div>
                    <div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" id="customRadioMale" type="radio" name="gender" required="required" /><label class="custom-control-label" for="customRadioMale">Male</label></div>
                    <div class="custom-control custom-radio custom-control-inline"><input class="custom-control-input" id="customRadioFemale" type="radio" name="gender" required="required" /><label class="custom-control-label" for="customRadioFemale">Female</label></div>
                  </div>
                  <div class="form-group col-md-6"><label class="font-weight-bold" for="inputDate">Appointment date</label><input class="form-control" id="inputDate" type="date" name="appointmentDate" required="required" /></div>
                </div>
                <div class="form-group">
                  <div class="custom-control custom-checkbox mb-3"><input class="custom-control-input" id="customControlCondition" type="checkbox" required="required" name="agree" /><label class="custom-control-label" for="customControlCondition">Confirmation and I agree with terms and conditions</label></div>
                </div>
                <div class="g-recaptcha mb-3" data-sitekey="6Lck1FAUAAAAAH3Y3wOtFAx5IjS2z_MD5WpNl4P9" data-theme="light"></div><input class="btn btn-primary" type="submit" name="submit" value="Submit" /><button class="btn btn-danger ml-2" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>