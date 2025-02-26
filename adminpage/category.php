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

$sql = "SELECT * FROM category";

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
            <h3 class="card-title">Category</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCategory" style="margin-left: auto;">
                + Category
            </button>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['category_name']; ?></td>
                            <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                <i class="fa fa-trash"></i>
                            </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      


    <div class="modal fade" id="addCategory">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Category</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="../backendAdmin/add_category.php">
                <div class="form-group">
                    <label for="category_name">Category</label>
                    <input type="text" name="category_name" id="category_name" class="form-control"  required>
                    <div id="categoryName-error" class="text-danger" style="display: none;"></div> 
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" id="addUser-btn" class="btn btn-success">Add</button>
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
                window.location.href = '../backendAdmin/delete_category.php?id=' + userId;
            }
        });
    }
</script>

<script>
$(document).ready(function() {
    $('#category_name').on('input', function() {
        let category_name = $(this).val();
        $.ajax({
            url: '../backendAdmin/check_category.php',
            type: 'POST',
            data: { category_name: category_name },
            success: function(response) {
                let data = JSON.parse(response);
                if (data.categoryName_error) {
                    $('#categoryName-error').text(data.categoryName_error).show();
                } else {
                    $('#categoryName-error').text('').hide();
                    if (!$('#categoryName-error').text()) {
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