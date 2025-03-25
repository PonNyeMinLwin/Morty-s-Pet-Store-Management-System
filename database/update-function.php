<?php
    $data = $_POST;
    $user_id = (int) $data['id'];
    $first_name = $data['f_name'];
    $last_name = $data['l_name'];
    $email = $data['email'];
    
    try {
        $sql = "UPDATE users SET email = ?, first_name = ?, last_name = ?, updated_at = ? WHERE id = ?";
        
        include('connector.php');
        $conn -> prepare($sql) -> execute([$email, $first_name, $last_name, date('Y-m-d H:i:s'), $user_id]);

        echo json_encode([
            'success' => true,
            'message' => $first_name . ' ' . $last_name . ' has been updated into the database!'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error processing request!'
        ]); 
    }
?>