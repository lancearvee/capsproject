<?php

require_once('../userLogin/db_con.php');
require_once('../pages/function/func_user.php');

// Set headers for JSON response and CORS
header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");

  


// Get request method
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
            $user_id = htmlspecialchars(trim($_GET['user_id']));
            error_log('User ID received: ' . $user_id); 
            $user_data = fetch_doctor_by_id($pdo, $user_id);
         
            if ($user_data) {
                echo json_encode(['success' => true, 'data' => $user_data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'User ID is required']);
        }
        break;
    
        if (isset($_GET['user_id']) && !empty($_GET['user_id']) && is_numeric($_GET['user_id'])) {
            $user_id = htmlspecialchars(trim($_GET['user_id']));
            error_log('User ID received: ' . $user_id);   
            
            $user_data = fetch_patient_by_id($pdo, $user_id);
        
            if ($user_data) {
                echo json_encode(['success' => true, 'data' => $user_data]);
            } else {
                echo json_encode(['success' => false, 'message' => 'User not found']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid or missing User ID']);
        }
        break;


        case 'PUT':
            // Handle PUT requests
            parse_str(file_get_contents('php://input'), $data);
            $result = fetch_doctor_by_id($pdo, $data);
            echo json_encode($result);
            break; 
            
    case 'POST':
        // Handle POST requests for adding data
        if (isset($_GET['add_user_info'])) {
            echo json_encode(add_user_info($pdo, $_POST));
            exit;
        } elseif (isset($_GET['add_user'])) {
            echo json_encode(add_user($pdo, $_POST));
            exit;
        } elseif (isset($_GET['add_staff'])) {
            echo json_encode(add_staff($pdo, $_POST));
            exit;
        } elseif (isset($_GET['add_patient'])) {
            echo json_encode(add_patient($pdo, $_POST));
            exit;
        } elseif (isset($_GET['add_useradmin'])) {
            echo json_encode(add_useradmin($pdo, $_POST));
            exit;
        } elseif (isset($_GET['update_doctor_data'])) { // Add this block for updating doctor data
            if (isset($_POST['user_id'])) {
                echo json_encode(update_doctor_data($pdo, $_POST)); 
            } else {
                echo json_encode(['success' => false, 'message' => 'User ID is required']);
            }
            exit;
        }
        break;

        case 'DELETE':
                $input = json_decode(file_get_contents('php://input'), true); // Parse JSON input
        
                if (isset($input['user_id'])) {
                    $user_id = $input['user_id'];
        
                    $response = delete_staff($pdo, $user_id);
                    echo json_encode($response);
                } else {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => 'User ID is required for deletion.',
                    ]);
                }
                break;
 
                if (isset($input['user_id']) && isset($input['municipality'])) {
                    $user_id = $input['user_id'];
                    $municipality = $input['municipality'];
                
                    $response = delete_patient($pdo, $user_id, $municipality);
                    echo json_encode($response);
                } else {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => 'User ID and Municipality are required for deletion.',
                    ]);
                }
            }


