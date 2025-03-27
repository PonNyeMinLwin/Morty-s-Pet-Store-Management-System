<?php
    $data = $_POST;
    
    $id = (int) $data['id'];
    $table = $data['table'];

    try {
        include('connector.php');

        // Deleting the joint table (product_suppliers) data
        if($table === 'suppliers') {
            $supplier_id = $id;
            $delete_method = "DELETE FROM product_suppliers WHERE supplier_id = {$id}";
            $conn->exec($delete_method);
        }

        if($table === 'products') {
            $product_id = $id;
            $delete_method = "DELETE FROM product_suppliers WHERE product_id = {$id}";
            $conn->exec($delete_method);
        }

        // Deleting the data from the main tables
        $delete_method = "DELETE FROM $table WHERE id = {$id}";
        $conn->exec($delete_method);

        echo json_encode([
            'success' => true,
            'message' => 'Deleted from the database!'
        ]);
        
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]); 
    }
?>