<?php
require '../userLogin/db_con.php';

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if ($user_id) {
    $sql = "SELECT cl.heart_pulse, cl.tendency_bleed, cl.diabetic, cl.oxg_saturation, cl.symptoms, cl.temp, cl.height, cl.blood_pressure, cl.weight, cl.sugar_rate, cl.family_med_history, cl.respiratory_rate, cl.t_level, cl.tsh_level, cl.known_thyroid_conditions, cl.thyroid_cond_desc, cl.current_thy_med, cl.date_check, cl.image,
    p.brand_name, p.medicine_name, p.dosage, p.gram
 FROM check_lab cl
 LEFT JOIN prescription p ON cl.appointment_fk_id = p.appointment_fk_id
 WHERE cl.user_id = :user_id
 ORDER BY cl.date_check ASC";  

    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $lab_data = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        
        if ($lab_data) {
            $output = '';
            $grouped_data = [];

            foreach ($lab_data as $record) {
                $date = date('F j, Y', strtotime($record['date_check']));
                
                if (!isset($grouped_data[$date])) {
                    $grouped_data[$date] = [
                        'lab' => $record,
                        'prescriptions' => []
                    ];
                }
                
                if ($record['brand_name']) {
                    $grouped_data[$date]['prescriptions'][] = [
                        'brand_name' => $record['brand_name'],
                        'medicine_name' => $record['medicine_name'] ?? 'N/A',
                        'dosage' => $record['dosage'] ?? 'N/A',
                        'gram' => $record['gram'] ?? 'N/A',
                    ];
                }
            }

            foreach ($grouped_data as $date => $data) {
                $output .= '<div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 15px;">';
                $output .= "<h6><strong>Date - $date</strong></h6>";
                
            
                foreach ($data['lab'] as $key => $value) {
                    // Only output non-image lab details
                    if ($key != 'date_check' && $key != 'image' && $key != 'brand_name' && $key != 'medicine_name' && $key != 'dosage' && $key != 'gram' && $value) {  
                        $output .= "<div><strong>" . ucwords(str_replace('_', ' ', $key)) . ":</strong> $value</div>";
                    }
                }
            
                // Display only the image with the click handler to open modal
                if (!empty($data['lab']['image'])) {
                    $output .= "<div style='display: flex; justify-content: flex-end; align-items: center; height: 100%;'>
                                    <img src='../results_images/{$data['lab']['image']}' alt='Results Image' style='max-width: 150px; max-height: 150px;' class='view-thyroid-med' data-image-path='../results_images/{$data['lab']['image']}'>
                                 </div>";
                }
                
                if (!empty($data['prescriptions'])) {
                    $output .= '<div style="border-top: 1px solid #ddd; margin-top: 10px; padding-top: 10px;">';
                    $output .= '<h6><strong>Prescription Details</strong></h6>';
                    foreach ($data['prescriptions'] as $prescription) {
                        $gram_display = $prescription['gram'];
                        if ($prescription['dosage'] === 'Tablet') {
                            $gram_display .= ' mg';  
                        } elseif ($prescription['dosage'] === 'Liquid') {
                            $gram_display .= ' ml';  
                        }
            
                        $output .= "<div><strong>{$prescription['brand_name']} - {$prescription['medicine_name']}, {$prescription['dosage']} ($gram_display)</strong></div>";
                    }
                    $output .= '</div>';
                }
            
                $output .= '</div>';
            }
            

            echo $output;
        } else {
            echo 'No lab data available.';
        }
    } catch (PDOException $e) {
        echo 'Error fetching lab data: ' . $e->getMessage();
    }
} else {
    echo 'Invalid user ID.';
}
?>
