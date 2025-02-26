<div class="modal fade bd-example-modal-lg" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Make Appointment</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body p-4">
                    <form action="../backendUser/appointment_profile_upd.php" method="POST">
                        <div class="zform-feedback"></div>
                        <small class="form-text text-muted">Leave blank to the information that is not applicable.</small>
                        <input class="form-control font-italic" type="hidden" name="to" value="username@domain.extension" />

                        <!-- Row 1 -->
                        <div class="form-row mb-3">
                            <div class="col-md-4">
                                <label for="given_name">Firstname Name</label>
                                <input type="text" class="form-control font-italic" id="given_name" name="given_name" value="<?= $given_name ?? ''; ?>" placeholder="Enter your name" required>
                                
                            </div>
                            <div class="col-md-4">
                                <label for="family_name">Last Name</label>
                                <input type="text" class="form-control font-italic" id="family_name" name="family_name" value="<?= $family_name ?? ''; ?>"  placeholder="Enter family name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="middle_name">Middle Name</label>
                                <input type="text" class="form-control font-italic" id="middle_name" name="middle_name" value="<?= $middle_name ?? ''; ?>"  placeholder="Enter middle name">
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="form-row mb-3">
                            <div class="col-md-4">
                                <label for="suffix">Suffix</label>
                                <select class="form-control font-italic" id="suffix" name="suffix">
                                    <option value="">--- Select ---</option>
                                    <option value="Jr." <?= ($suffix == "Jr.") ? 'selected' : ''; ?>>Jr.</option>
                                    <option value="Sr." <?= ($suffix == "Sr.") ? 'selected' : ''; ?>>Sr.</option>
                                    <option value="II" <?= ($suffix == "II") ? 'selected' : ''; ?>>II</option>
                                    <option value="III" <?= ($suffix == "III") ? 'selected' : ''; ?>>III</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="date_of_birth">Date of Birth<span class="text-danger">*</span></label>
                                <input type="date" class="form-control font-italic" id="date_of_birth" value="<?= $date_of_birth ?? ''; ?>"  name="date_of_birth" required>
                            </div>
                            <div class="col-md-4">
                                <label>Gender</label>
                                <div>
                                    <label for="male" class="mr-2">Male</label>
                                    <input type="radio" id="male" name="gender" value="Male" <?= ($gender == "Male") ? 'checked' : ''; ?> required>
                                    <label for="female" class="ml-3 mr-2">Female</label>
                                    <input type="radio" id="female" name="gender" value="Female" <?= ($gender == "Female") ? 'checked' : ''; ?> required>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3 -->
                        <div class="form-row mb-3">
                            <div class="col-md-4">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" class="form-control font-italic" id="contact_number" name="contact_number" value="<?= $contact_number ?? ''; ?>"  placeholder="Enter contact number">
                            </div>
                            <div class="col-md-4">
                                <label for="province">Province</label>
                                <select class="form-control font-italic" id="province" name="province">
                                    <option value="" disabled selected>--- Select ----</option>
                                    <?php foreach ($locations as $provinceKey => $municipalities): ?>
                                        <option value="<?= $provinceKey ?>" <?= ($provinceKey == $province) ? 'selected' : ''; ?>><?= $provinceKey ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="municipality">Municipality</label>
                                <select class="form-control font-italic" id="municipality" name="municipality">
                                    <option value="" disabled selected></option>
                                    <option value="<?= $municipality ?>" <?= ($municipality == $municipality) ? 'selected' : ''; ?>><?= $municipality ?></option>
                                </select>
                            </div>
                        </div>

                        <!-- Additional Rows -->
                        <div class="form-row mb-3">
                            <div class="col-md-4">
                                <label for="barangay">Barangay</label>
                                <select class="form-control font-italic" id="barangay" name="barangay">
                                    <option value="" disabled selected></option>
                                    <option value="<?= $barangay ?>" <?= ($barangay == $barangay) ? 'selected' : ''; ?>><?= $barangay ?></option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control font-italic" id="email" name="email"  value="<?= $email ?? ''; ?>" placeholder="Enter email">
                            </div>
                            <div class="col-md-4">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" class="form-control font-italic" id="postal_code" name="postal_code"  value="<?= $postal_code ?? ''; ?>"  placeholder="Enter postal code">
                            </div>
                        </div>
                         <!-- Additional Rows -->

                        <div class="form-row mb-3">
                            <div class="col-md-4">
                                <label for="heart_disease">Heart Disease</label>
                                <input type="text" class="form-control font-italic" id="heart_disease" name="heart_disease"  value="<?= $heart_disease ?? ''; ?>"  placeholder="Enter heart disease">
                            </div>
                            <div class="col-md-4">
                                <label for="any_accident">Any Accident</label>
                                <input type="any_accident" class="form-control font-italic" id="any_accident" name="any_accident"  value="<?= $any_accident ?? ''; ?>" placeholder="Enter  accident">
                            </div>
                            <div class="col-md-4">
                                <label for="any_surgery">Any Surgery</label>
                                <input type="text" class="form-control font-italic" id="any_surgery" name="any_surgery"  value="<?= $any_surgery ?? ''; ?>"  placeholder="Enter previous surgery">
                            </div>
                        </div>
                         <!-- Additional Rows -->

                        <div class="form-row mb-3">
                            <div class="col-md-4">
                                <label for="allergies">Allergies</label>
                                <input type="text" class="form-control font-italic" id="allergies" name="allergies"  value="<?= $allergies ?? ''; ?>"  placeholder="Enter your allergies">
                            </div>
                            <div class="col-md-4">
                                <label for="cond_med">Current Medications</label>
                                <input type="text" class="form-control font-italic" id="cond_med" name="cond_med"  value="<?= $cond_med ?? ''; ?>"  placeholder="Enter your current medication">
                            </div>
                            <div class="col-md-4">
                                <label for="medical_history">Medical History</label>
                                <input type="text" class="form-control font-italic" id="medical_history" name="medical_history"  value="<?= $medical_history ?? ''; ?>"  placeholder="Enter previous medical history">
                            </div>
                        </div>
                        <div class="modal-footer text-right">
                            <input class="btn btn-primary" type="submit" name="submit" value="Done" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>