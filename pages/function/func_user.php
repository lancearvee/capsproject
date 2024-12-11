<?php
function get_all_users($pdo) {
  $datenow = date('Y-m-d');
  $query = "SELECT * FROM tbl_checklist ";
  $query .= "WHERE DateChecked like '%$datenow%'";
  $statement = $pdo->query($query);
  return $statement->fetchAll();
}

function fetch_doctor_by_id($pdo, $user_id) {
  $query = "SELECT * FROM doctors WHERE doctor_ID = :doctor_ID";
  $statement = $pdo->prepare($query);
  $statement->bindParam(':doctor_ID', $user_id, PDO::PARAM_INT);
  $statement->execute();
 
  if ($statement->rowCount() > 0) {
      return $statement->fetch(PDO::FETCH_ASSOC);
  } else {
      return null;  // Return null if no record is found
  }
}

function fetch_patient_by_id($pdo, $user_id) {
  try {
      $query = "
          SELECT 
              patients.*, 
              municipalities.name AS municipality_name
          FROM 
              patients
          LEFT JOIN 
              municipalities 
          ON 
              patients.municipality_id = municipalities.id
          WHERE 
              patients.id = :id
      ";
      
      $statement = $pdo->prepare($query);
      $statement->bindParam(':id', $user_id, PDO::PARAM_INT);
      
      $statement->execute();
      
      if ($statement->rowCount() > 0) {
          return $statement->fetch(PDO::FETCH_ASSOC);  // Return the patient data
      } else {
          return null;  // No record found for the given user_id
      }
  } catch (PDOException $e) {
      error_log('Database error in fetch_patient_by_id: ' . $e->getMessage());  // Log any database error
      return null;  // Return null if there's an error
  }
}

function update_doctor_data($pdo, $data) {
  try {
      // Prepare the update query
      $query = "UPDATE doctors SET 
          last_name = :last_name,
          first_name = :first_name,
          middle_name = :middle_name,
          date_of_birth = :date_of_birth,
          gender = :gender,
          specialization = :specialization,
          contact_number = :contact_number,
          experience_years = :experience_years,
          availability = :availability,
          email = :email,
          address = :address,
          city = :city,
          state = :state
          WHERE doctor_ID = :doctor_ID";

      $statement = $pdo->prepare($query);

      // Bind parameters to the query
      $statement->bindParam(':doctor_ID', $data['user_id'], PDO::PARAM_INT);
      $statement->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
      $statement->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
      $statement->bindParam(':middle_name', $data['middle_name'], PDO::PARAM_STR);
      $statement->bindParam(':date_of_birth', $data['date_of_birth'], PDO::PARAM_STR);
      $statement->bindParam(':gender', $data['gender'], PDO::PARAM_STR);
      $statement->bindParam(':specialization', $data['specialization'], PDO::PARAM_STR);
      $statement->bindParam(':contact_number', $data['contact_number'], PDO::PARAM_STR);
      $statement->bindParam(':experience_years', $data['experience_years'], PDO::PARAM_INT);
      $statement->bindParam(':availability', $data['availability'], PDO::PARAM_STR);
      $statement->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $statement->bindParam(':address', $data['address'], PDO::PARAM_STR);
      $statement->bindParam(':city', $data['city'], PDO::PARAM_STR);
      $statement->bindParam(':state', $data['state'], PDO::PARAM_STR);

      // Execute the update query
      $statement->execute();

      return ['success' => true, 'message' => 'Doctor data updated successfully'];
  } catch (PDOException $e) {
      return ['success' => false, 'message' => 'Error updating doctor data: ' . $e->getMessage()];
  }
}

function update_patient_data($pdo, $data) {
  try {
      // Prepare the update query
      $query = "UPDATE doctors SET 
          last_name = :last_name,
          first_name = :first_name,
          middle_name = :middle_name,
          date_of_birth = :date_of_birth,
          gender = :gender,
          specialization = :specialization,
          contact_number = :contact_number,
          experience_years = :experience_years,
          availability = :availability,
          email = :email,
          address = :address,
          city = :city,
          state = :state
          WHERE doctor_ID = :doctor_ID";

      $statement = $pdo->prepare($query);

      // Bind parameters to the query
      $statement->bindParam(':doctor_ID', $data['user_id'], PDO::PARAM_INT);
      $statement->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
      $statement->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
      $statement->bindParam(':middle_name', $data['middle_name'], PDO::PARAM_STR);
      $statement->bindParam(':date_of_birth', $data['date_of_birth'], PDO::PARAM_STR);
      $statement->bindParam(':gender', $data['gender'], PDO::PARAM_STR);
      $statement->bindParam(':specialization', $data['specialization'], PDO::PARAM_STR);
      $statement->bindParam(':contact_number', $data['contact_number'], PDO::PARAM_STR);
      $statement->bindParam(':experience_years', $data['experience_years'], PDO::PARAM_INT);
      $statement->bindParam(':availability', $data['availability'], PDO::PARAM_STR);
      $statement->bindParam(':email', $data['email'], PDO::PARAM_STR);
      $statement->bindParam(':address', $data['address'], PDO::PARAM_STR);
      $statement->bindParam(':city', $data['city'], PDO::PARAM_STR);
      $statement->bindParam(':state', $data['state'], PDO::PARAM_STR);

      // Execute the update query
      $statement->execute();

      return ['success' => true, 'message' => 'Doctor data updated successfully'];
  } catch (PDOException $e) {
      return ['success' => false, 'message' => 'Error updating doctor data: ' . $e->getMessage()];
  }
}

//alert($('#a_user_id_no').val());
function get_user_result($pdo, $access_level) {
    if ($access_level == 'RO') {
    $query = "SELECT * FROM tbl_checklist"; 
  } else
    {
    $query = "SELECT * FROM tbl_checklist WHERE Office = '".$access_level."'";
    }    
    $statement = $pdo->query($query);
    return $statement->fetchAll();
}

function get_all_usersinfo($pdo) {
  $datenow = date('Y-m-d');
  $query = "SELECT * FROM tbl_users";  
  $statement = $pdo->query($query);
  return $statement->fetchAll();
}

function add_user_info($pdo, $data) {
  extract($data);
  $query = "INSERT INTO tbl_checklist ";
  $query .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $pdo->beginTransaction();
  try {
    $statement = $pdo->prepare($query);
    $statement->execute([ $user_id_no, $user_name, $user_sex, $user_age, $user_office, $user_date, $user_temp, $item1, $item2, $item3, $item4, $item5, $item6, $item7 ]);
    $insert_id = $pdo->lastInsertId();       
    $pdo->commit();
    $resp = [
      'success' => true,
      'status' => 'success',
      'message' => 'Staff Record was successfully created!',
      'insert_id' => $insert_id
      ];   
  } catch (\Exception $e) {
    $resp = [
      'success' => false,
      'status' => 'failed',
      'message' => 'Duplicate entry!',
    ];
    $pdo->rollBack();
  }
  return $resp;
}

function add_user($pdo, $data) {
  extract($data);

  // Check if the email already exists in the database
  $checkQuery = "SELECT COUNT(*) FROM users WHERE email = ?";
  $checkStatement = $pdo->prepare($checkQuery);
  $checkStatement->execute([$email]);

  // If email exists 
  if ($checkStatement->fetchColumn() > 0) {
    return [
      'success' => false,
      'status' => 'failed',
      'message' => 'The email is already registered.',
    ];
  }
 
  $query = "INSERT INTO users (name, email, password, user_type) 
            VALUES (?, ?, ?, ?)";

  $pdo->beginTransaction();
  try {
    $statement = $pdo->prepare($query);
    $statement->execute([ $name, $email, $password, $user_type]);
    $insert_id = $pdo->lastInsertId();  
    $pdo->commit();
    $resp = [
      'success' => true,
      'status' => 'success',
      'message' => 'Record was successfully created!',
      'insert_id' => $insert_id
    ];   
  } catch (\Exception $e) {
    $resp = [
      'success' => false,
      'status' => 'failed',
      'message' => 'Error: ' . $e->getMessage(),
    ];
    $pdo->rollBack();
  }

  return $resp;
}

function add_staff($pdo, $data) {
  extract($data);
  // Check if email already exists
  $checkEmailQuery = "SELECT COUNT(*) FROM doctors WHERE email = ?";
  $checkEmailStatement = $pdo->prepare($checkEmailQuery);
  $checkEmailStatement->execute([$email]);

  // If email exists, return a response indicating duplicate
  if ($checkEmailStatement->fetchColumn() > 0) {
    return [
      'success' => false,
      'status' => 'failed',
      'message' => 'The email is already registered.',
    ];
  }
 
  // Proceed with the insertion if both email and contact number are unique
  $query = "INSERT INTO doctors ";
  $query .= "(doctor_ID, last_name, first_name, middle_name, date_of_birth, gender, specialization, contact_number, experience_years, availability, email, address, city, state) ";
  $query .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $pdo->beginTransaction();
  try {
    $statement = $pdo->prepare($query);
    $statement->execute([
      $doctor_ID, $last_name, $first_name, $middle_name, $date_of_birth, $gender, 
      $specialization, $contact_number, $experience_years, $availability, 
      $email, $address, $city, $state
    ]);
    
    $insert_id = $pdo->lastInsertId();  
    $pdo->commit();
    
    $resp = [
      'success' => true,
      'status' => 'success',
      'message' => 'Staff record was successfully created!',
      'insert_id' => $insert_id
    ];   
  } catch (\Exception $e) {
    $resp = [
      'success' => false,
      'status' => 'failed',
      'message' => 'Error: ' . $e->getMessage(),
    ];
    $pdo->rollBack();
  }

  return $resp;
}


function add_patient($pdo, $data) {
  extract($data);

  // Define the columns explicitly to match the database schema
  $query = "INSERT INTO patients 
            (last_name, first_name, middle_name, date_of_birth, gender, municipality_id, 
             contact_number, email, address, city, state, postal_code, medical_history) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $pdo->beginTransaction();
  try {
      // Prepare and execute the statement
      $statement = $pdo->prepare($query);
      $statement->execute([
          $last_name, $first_name, $middle_name, $date_of_birth, $gender, 
          $municipality_id, $contact_number, $email, $address, $city, 
          $state, $postal_code, $medical_history
      ]);

      // Get the ID of the last inserted record
      $insert_id = $pdo->lastInsertId();

      // Commit the transaction
      $pdo->commit();

      // Return a success response
      return [
          'success' => true,
          'status' => 'success',
          'message' => 'Patient record was successfully created!',
          'insert_id' => $insert_id
      ];
  } catch (\Exception $e) {
      // Rollback the transaction on error
      $pdo->rollBack();

      // Return the error details
      return [
          'success' => false,
          'status' => 'failed',
          'message' => $e->getMessage(),
      ];
  }
}
  

function add_useradmin($pdo, $data) {
  extract($data);
  
  $query = "INSERT INTO tbl_users ";
  $query .= "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $pdo->beginTransaction();
  try {
    $statement = $pdo->prepare($query);
    $statement->execute([ NULL, $user_id_no, $fullname, $user_sex, $age, $position, $office, $username, $password, $office ]);
    $insert_id = $pdo->lastInsertId();  
    $pdo->commit();
    $resp = [
      'success' => true,
      'status' => 'success',
      'message' => 'Employee Record was successfully created!',
      'insert_id' => $insert_id
      ];   
  } catch (\Exception $e) {
    $resp = [
      'success' => false,
      'status' => 'failed',
      'message' => 'Duplicate Entry',
    ];
    $pdo->rollBack();
  }
  return $resp;
}

function get_user_by_id($pdo, $user_id) {
  try {
      $query = "SELECT * FROM doctors WHERE doctor_ID = :doctor_ID";
      $stmt = $pdo->prepare($query);
      $stmt->execute(['doctor_ID' => $user_id]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (\Exception $e) {
      return null;
  }
}

 

function delete_staff($pdo, $user_id) {
  error_log("Attempting to delete user with ID: " . $user_id);

  $query = "DELETE FROM doctors WHERE doctor_ID = ?";
  $pdo->beginTransaction();

  try {
      $statement = $pdo->prepare($query);
      $statement->execute([$user_id]);

      error_log("Executed query: DELETE FROM doctors WHERE doctor_ID = " . $user_id);

      if ($statement->rowCount() > 0) { // Check if any rows were deleted
          $pdo->commit();
          return [
              'success' => true,
              'message' => 'User record was successfully deleted!',
          ];
      } else {
          $pdo->rollBack();
          return [
              'success' => false,
              'message' => 'User record not found.',
          ];
      }
  } catch (Exception $e) {
      $pdo->rollBack();
      error_log("Error deleting user: " . $e->getMessage());

      return [
          'success' => false,
          'message' => 'Server error: ' . $e->getMessage(),
      ];
  }
}


function delete_patient($pdo, $user_id) {
  error_log("Attempting to delete patient with ID: $user_id");

  // Ensure user_id is an integer
  $user_id = (int) $user_id;
  error_log("User ID (after cast): $user_id");

  // Query to check the patient and municipality
  $checkQuery = "SELECT municipality_id FROM patients WHERE id = :id";
  $pdo->beginTransaction();

  try {
      // Prepare and execute the query to check for the patient
      $checkStmt = $pdo->prepare($checkQuery);
      $checkStmt->bindParam(':id', $user_id, PDO::PARAM_INT);
      $checkStmt->execute();

      // Fetch the municipality_id for the patient
      $municipality_id = $checkStmt->fetchColumn();
      if (!$municipality_id) {
          error_log("No patient found with ID: $user_id");
          $pdo->rollBack();
          return [
              'success' => false,
              'message' => 'User record not found.',
          ];
      }

      error_log("Patient found with ID: $user_id, Municipality ID: $municipality_id");

      // Proceed with deletion
      $query = "DELETE FROM patients WHERE id = :id";
      $deleteStmt = $pdo->prepare($query);
      $deleteStmt->bindParam(':id', $user_id, PDO::PARAM_INT);
      $deleteStmt->execute();

      if ($deleteStmt->rowCount() > 0) {
          // If desired, you can also delete or update the municipality record
          // Uncomment if needed:
          // $deleteMunicipalityQuery = "DELETE FROM municipalities WHERE id = :municipality_id";
          // $deleteMunicipalityStmt = $pdo->prepare($deleteMunicipalityQuery);
          // $deleteMunicipalityStmt->bindParam(':municipality_id', $municipality_id, PDO::PARAM_INT);
          // $deleteMunicipalityStmt->execute();

          $pdo->commit();
          return [
              'success' => true,
              'message' => 'Patient record was successfully deleted!',
          ];
      } else {
          error_log("Failed to delete patient with ID: $user_id");
          $pdo->rollBack();
          return [
              'success' => false,
              'message' => 'Failed to delete patient record.',
          ];
      }
  } catch (Exception $e) {
      $pdo->rollBack();
      error_log("Error deleting patient: " . $e->getMessage());
      return [
          'success' => false,
          'message' => 'Server error: ' . $e->getMessage(),
      ];
  }
}
