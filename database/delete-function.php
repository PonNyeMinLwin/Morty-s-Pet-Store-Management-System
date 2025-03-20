<?php
    $data = $_POST;
    $user_id = (int) $data['id'];
    $first_name = $data['f_name'];
    $last_name = $data['l_name'];
    
    try {
        $delete_method = "DELETE FROM users WHERE id = {$user_id}";
        
        include('connector.php');

        $conn->exec($delete_method);

        echo json_encode([
            'success' => true,
            'message' => $first_name . ' ' . $last_name . ' has been deleted from the database!'
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error processing request!'
        ]); 
    }
?>