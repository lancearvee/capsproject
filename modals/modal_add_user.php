<form id="addUserForm" action="../api/api_users.php" method="post">
  <div id="addUserModal" class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title">Add New User</h4>
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

          <div class="form-group row">
            <div class="col-4">
              <label for="a_last_name">Last Name<span class="h5 text-danger">*</span></label>
              <input type="text" name="last_name" id="a_last_name" class="form-control" onkeyup="this.value = this.value.toLowerrCase()" onpaste="this.value = this.value.toLowerCase()" required>
            </div>
            <div class="col-4">
              <label for="a_first_name">First Name<span class="h5 text-danger">*</span></label>
              <input type="text" name="first_name" id="a_first_name" class="form-control" onkeyup="this.value = this.value.toUpperCase()" onpaste="this.value = this.value.toUpperCase()" required>
            </div>
            <div class="col-4">
              <label for="a_middle_name">Middle Name<span class="h5 text-danger">*</span></label>
              <input type="text" name="middle_name" id="a_middle_name" class="form-control" onkeyup="this.value = this.value.toUpperCase()" onpaste="this.value = this.value.toUpperCase()" required>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-6">
              <label for="a_username">Username<span class="h5 text-danger">*</span></label>
              <input type="text" name="username" id="a_username" class="form-control" required>
            </div>
            <div class="col-6">
              <label for="a_password">Password<span class="h5 text-danger">*</span></label>
              <input type="password" name="password" id="a_password" class="form-control" required>
            </div>
          </div>

        </div> <!--modal body-->

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Create</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript"></script>
<script>



      //Add User Account Modal
      $('[data-action="add_userinfo"]').click(function() {
        document.getElementById('addUserForm').reset();
      });

      // Add User Account
      $('#addUserForm').submit(function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Information',
          text: "Are you sure you want to add this Result?",
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, save it!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              url: '../api/api_users.php?add_userinfo',
              type: 'post',
              processData: false,
              contentType: false,
              data: new FormData(this)
            }).then(function(response) {
              if(response.success){
                Swal.fire('Success!', response.message, 'success')
              }else{
                Swal.fire('Warning!', response.message, 'warning')
              }

            })
          }
        })
      });
</script>

