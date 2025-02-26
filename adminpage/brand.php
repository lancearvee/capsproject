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

$sql = "SELECT id, brand_name, cat_fk_id, category_name, supplier FROM brand";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $brand = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $stmt = $pdo->prepare("SELECT category_name, id FROM category");
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
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
            <h3 class="card-title">Brand</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBrand" style="margin-left: auto;">
                + Brand
            </button>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Brand Name</th>
                            <th>Supplier</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($brand as $brand): ?>
                        <tr>
                            <td><?php echo $brand['category_name']; ?></td>
                            <td><?php echo $brand['brand_name']; ?></td>
                            <td><?php echo $brand['supplier']; ?></td>

                            <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editCategoryModal<?php echo $brand['id']; ?>">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $brand['id']; ?>)">
                                <i class="fa fa-trash"></i>
                            </button>

                            </td>
                        </tr>

                        <!-- Modal to display and edit user details -->
                            <div class="modal fade" id="editCategoryModal<?php echo $brand['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel<?php echo $brand['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCategoryModalLabel<?php echo $brand['id']; ?>">Edit Brand</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <form method="POST" action="../backendAdmin/update_brand.php">
                                            <input type="hidden" name="id" value="<?php echo $brand['id']; ?>">
                                            <div class="form-group">
                                                <label for="name">Category_name</label>
                                                <select name="category_name" id="category_name" class="form-control" required>
                                                    <option value="" disabled selected>Select a category</option>
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                                            <?php if ($category['id'] == $brand['cat_fk_id']) echo 'selected'; ?>>
                                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="brand_name">Brand Name</label>
                                                <input type="text" name="brand_name"  value="<?php echo $brand['brand_name']; ?>" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="supplier">Supplier</label>
                                                <input type="text" name="supplier" value="<?php echo $brand['supplier']; ?>" class="form-control" required>
                                            </div>
                                            <div class="modal-footer justify-content-end">
                                                <button type="submit" class="btn btn-success">Update</button>
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
      


    <div class="modal fade" id="addBrand">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Category</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="../backendAdmin/add_brand.php">
                <div class="form-group">
                    <label for="category_name">Category</label>
                    <select name="category_name" id="category_name" class="form-control" required>
                        <option value="" disabled selected>Select a category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                <?php echo htmlspecialchars($category['category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="brand_name">Brand Name</label>
                    <input type="text" name="brand_name" id="brand_name" class="form-control"  required>
                    <div id="brand-error" class="text-danger" style="display: none;"></div> 
                </div>
                <div class="form-group">
                    <label for="supplier">Supplier</label>
                    <input type="text" name="supplier" class="form-control"  required>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-success">Add</button>
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
                window.location.href = '../backendAdmin/delete_brand.php?id=' + userId;
            }
        });
    }
</script>

<script>
$(document).ready(function() {
    $('#brand_name').on('input', function() {
        let brand_name = $(this).val();
        $.ajax({
            url: '../backendAdmin/check_brand.php',
            type: 'POST',
            data: { brand_name: brand_name },
            success: function(response) {
                let data = JSON.parse(response);
                if (data.brand_error) {
                    $('#brand-error').text(data.brand_error).show();
                } else {
                    $('#brand-error').text('').hide();
                    if (!$('#brand-error').text()) {
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