<?php
function get_user_password_by_user_id($pdo, $user_id) {
  $query = "SELECT user_id, password FROM tbl_users ";
  $query .= "WHERE user_id = ? ";
  $statement = $pdo->prepare($query);
  $statement->execute([ $user_id ]);
  return $statement->fetchObject();
}

function edit_user_password($pdo, $data) {
  extract($data);
  $user_id = isset($user_id) && !empty($user_id) ? trim($user_id) : null;
  $password = isset($password) && !empty($password) ? trim($password) : null;
  $query = "UPDATE tbl_users SET password = ? ";
  $query .= "WHERE user_id = ? ";
  $pdo->beginTransaction();
  try {
    $statement = $pdo->prepare($query);
    $statement->execute([ $password, $user_id ]);
    $response = [
      'success' => true,
      'status' => 'success',
      'message' => 'Your password was successfully updated!',
    ];
    $pdo->commit();
  } catch (\Exception $e) {
    $response = [
      'success' => false,
      'status' => 'failed',
      'message' => $e->getMessage(),
    ];
    $pdo->rollBack();
  }
  return $response;
}
?>
