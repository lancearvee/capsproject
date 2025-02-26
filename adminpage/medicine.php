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

$sql = "SELECT id, medicine_name, brand_fk_id, brand_name, dosage, gram, price_unit, stock_qty, expiry_date, qty_pack, regulatory_app_no FROM medicine";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $medicine = $stmt->fetchAll();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



try {
    $stmt = $pdo->prepare("SELECT brand_name, id FROM brand");
    $stmt->execute();
    $brands = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error fetching brands: " . $e->getMessage();
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
            <h3 class="card-title">Medicine</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBrand" style="margin-left: auto;">
                + Medicine
            </button>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Brand</th>
                            <th>Dosage</th>
                            <th>Grams/MG</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Expiration</th>
                            <th>Quantity in Pack</th>
                            <th>Regulatory Approval Number</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicine as $medicine): ?>
                        <tr>
                            <td><?php echo $medicine['medicine_name']; ?></td>
                            <td><?php echo $medicine['brand_name']; ?></td>
                            <td><?php echo $medicine['dosage']; ?></td>
                            <td>
                                <?php 
                                if ($medicine['dosage'] == 'Tablet') {
                                    echo $medicine['gram'] . ' mg';
                                } elseif ($medicine['dosage'] == 'Liquid') {
                                    echo $medicine['gram'] . ' ml';
                                }
                                ?>
                            </td>
                            <td><?php echo !empty($medicine['price_unit']) ? '₱' . number_format($medicine['price_unit'], 2) : 'None';?></td>

                            <td>
                                <?php 
                                    echo $medicine['stock_qty'] . ' pcs'; 
                                    if ($medicine['stock_qty'] <= 10) {
                                        echo ' <i class="fa fa-exclamation-circle text-danger"></i>';
                                    }
                                ?> 
                            </td>


                            <td><?php echo date('F j, Y', strtotime($medicine['expiry_date'])); ?></td>
                            <td><?php echo $medicine['qty_pack']; ?> pcs per pack</td>
                            <td><?php echo $medicine['regulatory_app_no']; ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editCategoryModal<?php echo $medicine['id']; ?>">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $medicine['id']; ?>)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addStockModal<?php echo $medicine['id']; ?>">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#minusStockModal<?php echo $medicine['id']; ?>">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="minusStockModal<?php echo $medicine['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="minusStockModalLabel<?php echo $medicine['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="minusStockModalLabel<?php echo $medicine['id']; ?>">Minus Stock</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="../backendAdmin/minus_stock.php">
                                        <input type="hidden" name="id" value="<?php echo $medicine['id']; ?>">

                                        <!-- Selection for Pack or Per Piece -->
                                        <div class="form-group">
                                            <label for="selection-minus<?php echo $medicine['id']; ?>">Select Type</label>
                                            <select id="selection-minus<?php echo $medicine['id']; ?>" class="form-control" onchange="showMinusQuantityFields('<?php echo $medicine['id']; ?>')">
                                                <option value="per-piece">Per Piece</option>
                                                <option value="pack">Pack</option>
                                            </select>
                                        </div>

                                        <!-- Quantity Times (For Pack) -->
                                        <div class="form-group" id="quantity-times-group-minus<?php echo $medicine['id']; ?>" style="display: none;">
                                            <label for="quantity_times_minus<?php echo $medicine['id']; ?>">Quantity (Pack)</label>
                                            <input type="text" name="quantity_times" id="quantity_times_minus<?php echo $medicine['id']; ?>" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>

                                        <!-- Quantity (For Per Piece) -->
                                        <div class="form-group" id="quantity-group-minus<?php echo $medicine['id']; ?>">
                                            <label for="quantity_minus<?php echo $medicine['id']; ?>">Quantity (Per Piece)</label>
                                            <input type="text" name="quantity" id="quantity_minus<?php echo $medicine['id']; ?>" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>
                                        <input type="hidden" name="qty_pack" value="<?php echo $medicine['qty_pack']; ?>" >
                                        <input type="hidden" name="stock_qty" value="<?php echo $medicine['stock_qty']; ?>" >

                                        <div class="modal-footer justify-content-end">
                                            <button type="submit" class="btn btn-danger">Update</button>
                                        </div>
                                    </form>

                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="modal fade" id="addStockModal<?php echo $medicine['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel<?php echo $medicine['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addStockModalLabel<?php echo $medicine['id']; ?>">Add Stock</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="../backendAdmin/add_stock.php">
                                            <input type="hidden" name="id" value="<?php echo $medicine['id']; ?>">

                                            <div class="form-group">
                                                <label for="selection<?php echo $medicine['id']; ?>">Select Type</label>
                                                <select id="selection<?php echo $medicine['id']; ?>" class="form-control" onchange="showQuantityFields('<?php echo $medicine['id']; ?>')">
                                                <option value="per-piece">Per Piece</option>
                                                <option value="pack">Pack</option>
                                                </select>
                                            </div>

                                            <!-- Quantity Times (For Pack) -->
                                            <div class="form-group" id="quantity-times-group<?php echo $medicine['id']; ?>" style="display: none;">
                                                <label for="quantity_times<?php echo $medicine['id']; ?>">Quantity (Pack)</label>
                                                <input type="text" name="quantity_times" id="quantity_times<?php echo $medicine['id']; ?>" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');" >
                                            </div>

                                            <!-- Quantity (For Per Piece) -->
                                            <div class="form-group" id="quantity-group<?php echo $medicine['id']; ?>">
                                                <label for="quantity<?php echo $medicine['id']; ?>">Quantity (Per Piece)</label>
                                                <input type="text" name="quantity" id="quantity<?php echo $medicine['id']; ?>" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            </div>

                                            <input type="hidden" name="qty_pack" value="<?php echo $medicine['qty_pack']; ?>" >
                                            <input type="hidden" name="stock_qty" value="<?php echo $medicine['stock_qty']; ?>" >

                                            <div class="modal-footer justify-content-end">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        


                        <!-- Modal to display and edit user details -->
                        <div class="modal fade" id="editCategoryModal<?php echo $medicine['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel<?php echo $medicine['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryModalLabel<?php echo $medicine['id']; ?>">Edit Medicine</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" action="../backendAdmin/update_medicine.php">
                                            <input type="hidden" name="id" value="<?php echo $medicine['id']; ?>">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="brand_name">Brand Name</label>
                                                        <select name="brand_name" id="brand_name" class="form-control" required>
                                                            <option value="" disabled selected>Select a brand</option>
                                                            <?php
                                                            $selectedBrandId = $medicine['brand_fk_id']; 

                                                            try {
                                                                $stmt = $pdo->prepare("SELECT brand_name, id FROM brand");
                                                                $stmt->execute();
                                                                $brands = $stmt->fetchAll();

                                                                foreach ($brands as $brand) {
                                                                    $selected = ($brand['id'] == $selectedBrandId) ? 'selected' : '';
                                                                    echo "<option value='" . htmlspecialchars($brand['id']) . "' $selected>" . htmlspecialchars($brand['brand_name']) . "</option>";
                                                                }
                                                            } catch (PDOException $e) {
                                                                echo "Error fetching brand: " . $e->getMessage();
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="medicine_name">Medicine Name</label>
                                                        <input type="text" name="medicine_name" value="<?php echo $medicine['medicine_name']; ?>" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dosage">Dosage</label>
                                                        <select name="dosage" id="dosage" class="form-control" required>
                                                            <option value="">-- Select Dosage --</option>
                                                            <option value="Tablet" <?php echo $medicine['dosage'] == 'Tablet' ? 'selected' : ''; ?>>Tablet</option>
                                                            <option value="Liquid" <?php echo $medicine['dosage'] == 'Liquid' ? 'selected' : ''; ?>>Liquid</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="gram">Gram</label>
                                                        <input type="text" name="gram" value="<?php echo $medicine['gram']; ?>" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="price_unit">Price per Unit</label>
                                                        <input type="text" name="price_unit" value="<?php echo $medicine['price_unit']; ?>" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="expiry_date">Expiration</label>
                                                        <input type="date" name="expiry_date" value="<?php echo $medicine['expiry_date']; ?>" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="qty_pack">Quantity per Pack</label>
                                                        <input type="text" name="qty_pack" value="<?php echo $medicine['qty_pack']; ?>" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="regulatory_app_no">Regulatory Approved Number</label>
                                                        <input type="text" name="regulatory_app_no" value="<?php echo $medicine['regulatory_app_no']; ?>" class="form-control" required>
                                                    </div>
                                                </div>
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
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Medicine</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="../backendAdmin/add_medicine.php">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="brand_name">Brand</label>
                            <select name="brand_name" class="form-control" required>
                                <option value="" disabled selected>Select a brand</option>
                                <?php foreach ($brands as $brands): ?>
                                    <option value="<?php echo htmlspecialchars($brands['id']); ?>">
                                        <?php echo htmlspecialchars($brands['brand_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medicine_name">Medicine Name</label>
                            <input type="text" name="medicine_name" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dosage">Dosage</label>
                            <select name="dosage" class="form-control" required>
                                <option value="" disabled selected>Select Dosage</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Liquid">Liquid</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gram">Gram</label>
                            <input type="text" name="gram" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price_unit">Price per Unit</label>
                            <input type="text" name="price_unit" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="expiry_date">Expiration</label>
                            <input type="date" name="expiry_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="qty_pack">Quantity per Pack</label>
                            <input type="text" name="qty_pack" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="regulatory_app_no">Regulatory Approved Number</label>
                            <input type="text" name="regulatory_app_no" class="form-control" required>
                        </div>
                    </div>
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
                window.location.href = '../backendAdmin/delete_medicine.php?id=' + userId;
            }
        });
    }
</script>

<script>
function showMinusQuantityFields(medicineId) {
    var selection = document.getElementById('selection-minus' + medicineId).value;

    document.getElementById('quantity-times-group-minus' + medicineId).style.display = 'none';
    document.getElementById('quantity-group-minus' + medicineId).style.display = 'none';

    if (selection === 'pack') {
        document.getElementById('quantity-times-group-minus' + medicineId).style.display = 'block'; 
    } else {
        document.getElementById('quantity-group-minus' + medicineId).style.display = 'block'; 
    }
}
///////////////////////////////////////////////////////////
function showQuantityFields(medicineId) {
    var selection = document.getElementById('selection' + medicineId).value;

    document.getElementById('quantity-times-group' + medicineId).style.display = 'none';
    document.getElementById('quantity-group' + medicineId).style.display = 'none';

    if (selection === 'pack') {
        document.getElementById('quantity-times-group' + medicineId).style.display = 'block';
    } else {
        document.getElementById('quantity-group' + medicineId).style.display = 'block'; 
    }
}
</script>


<?php
include('../adminpage/footer.php');
?>