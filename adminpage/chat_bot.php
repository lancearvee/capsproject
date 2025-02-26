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

$sql = "SELECT id, question, answer FROM chatbot";

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
            <h3 class="card-title">ChatBot</h3>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMessage" style="margin-left: auto;">
                + Message
            </button>
            </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['question']; ?></td>
                            <td><?php echo $user['answer']; ?></td>
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
      


    <div class="modal fade" id="addMessage">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="../realtimechat/add_message.php">
                <div class="form-group">
                    <label for="question">Question</label>
                    <textarea name="question" id="question" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <textarea name="answer" id="answer" class="form-control" required></textarea>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit"  class="btn btn-success">Add</button>
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
                window.location.href = '../realtimechat/delete_message.php?id=' + userId;
            }
        });
    }
</script>


<?php
include('../adminpage/footer.php');
?>