<?php
include('../adminpage/header.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../userLogin/landing.php');
    exit();
}
$admin_id = $_SESSION['admin_id'];
?>
<?php
require '../userLogin/db_con.php';

$sql = "SELECT id, name, email, password, user_type FROM users";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll();

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
            <h3 class="card-title">Users</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="margin-left: auto;">
                + User
            </button>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['user_type']; ?></td>
                            <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editUserModal<?php echo $user['id']; ?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                <i class="fa fa-trash"></i>
                            </button>

                            </td>
                        </tr>

                        <!-- Modal to display and edit user details -->
                            <div class="modal fade" id="editUserModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserModalLabel<?php echo $user['id']; ?>">Edit User Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="../backendAdmin/update_user.php">
                                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                <div class="form-group">
                                                    <label for="name">Username</label>
                                                    <input type="text" name="name"  class="form-control" value="<?php echo $user['name']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email"  class="form-control" value="<?php echo $user['email']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                    <small class="form-text text-muted">Leave blank to keep the current password.</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_type">User Type</label>
                                                    <select name="user_type" class="form-control" required>
                                                        <option value="admin" <?php echo $user['user_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                        <option value="user" <?php echo $user['user_type'] === 'user' ? 'selected' : ''; ?>>User</option>
                                                        <option value="staff" <?php echo $user['user_type'] === 'staff' ? 'selected' : ''; ?>>Staff</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
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
      


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="../backendAdmin/add_user.php">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" name="name" id="name" class="form-control"  required>
                    <div id="name-error" class="text-danger" style="display: none;"></div> 
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <div id="email-error" class="text-danger" style="display: none;"></div> 
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="user_type">User Type</label>
                    <select name="user_type" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" id="addUser-btn" class="btn btn-primary">Add</button>
                </div>
            </form>
          </div>
        </div>
      </div>


    </section>
  </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    function deleteUser(userId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                window.location.href = '../backendAdmin/delete_user.php?id=' + userId;
            }
        });
    }
</script>

<script>
$(document).ready(function() {
    $('#name').on('input', function() {
        let name = $(this).val();
        $.ajax({
            url: '../backendAdmin/check_user.php',
            type: 'POST',
            data: { name: name },
            success: function(response) {
                let data = JSON.parse(response);
                if (data.name_error) {
                    $('#name-error').text(data.name_error).show();
                    $('#addUser-btn').prop('disabled', true);
                } else {
                    $('#name-error').text('').hide();
                    if (!$('#name-error').text()) {
                        $('#addUser-btn').prop('disabled', false);
                    }
                }
            }
        });
    });

    $('#email').on('input', function() {
        let email = $(this).val();
        $.ajax({
            url: '../backendAdmin/check_user.php',
            type: 'POST',
            data: { email: email },
            success: function(response) {
                let data = JSON.parse(response);
                if (data.email_error) {
                    $('#email-error').text(data.email_error).show();
                    $('#addUser-btn').prop('disabled', true);
                } else {
                    $('#email-error').text('').hide();
                    if (!$('#email-error').text()) {
                        $('#addUser-btn').prop('disabled', false);
                    }
                }
            }
        });
    });
});
</script>
<?php
include('../adminpage/footer.php');
?>