<?php
    $data = $_POST;
    
    $id = (int) $data['id'];
    $table = $data['table'];

    try {
        $delete_method = "DELETE FROM $table WHERE id = {$id}";
        
        include('connector.php');

        $conn->exec($delete_method);

        echo json_encode([
            'success' => true,
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
        ]); 
    }
?>