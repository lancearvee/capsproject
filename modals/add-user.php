<form id="addUser" action="../api/api_user.php" method="post">
  <div id="addUserModal" class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Add User</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Name Field -->
          <div class="form-group">
            <label for="name">Name<span class="h5 text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
          </div>

          <!-- Username (Email) Field -->
          <div class="form-group">
            <label for="email">Username(Email)<span class="h5 text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
          </div>

          <!-- Password Field -->
          <div class="form-group">
            <label for="password">Password<span class="h5 text-danger">*</span></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
          </div>

          <!-- User Type Dropdown -->
          <div class="form-group">
            <label for="user_type">User Type<span class="h5 text-danger">*</span></label>
            <select class="form-control" id="user_type" name="user_type" required>
              <option value="">Select User Type</option>
              <option value="Admin">admin</option>
              <option value="Staff">staff</option>
              <option value="User">user</option>
            </select>
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
