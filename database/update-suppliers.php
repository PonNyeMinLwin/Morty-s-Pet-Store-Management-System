<?php
    include('connector.php');

    // Getting the new supplier information from the user
    $supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
    $supplier_location = isset($_POST['supplier_location']) ? $_POST['supplier_location'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $supplier_id = $_POST['id'];

    try {
        // Saving the new information and updating the 'View Products' table
        $update_method = "UPDATE suppliers SET supplier_name = ?, supplier_location = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($update_method);
        $stmt->execute([$supplier_name, $supplier_location, $email, $supplier_id]);

        // Deleting the old values from the product_suppliers table
        $delete_method = "DELETE FROM product_suppliers WHERE supplier_id = ?";
        $stmt = $conn->prepare($delete_method);
        $stmt->execute([$supplier_id]);

        // Getting products
        $products = isset($_POST['products']) ? $_POST['products'] : [];
        foreach($products as $product) {
            if (empty($product)) continue;

            $supplier_data = ['supplier_id' => $supplier_id, 'product_id' => $product, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
            $insert_method = "INSERT INTO product_suppliers (supplier_id, product_id, created_at, updated_at) VALUES (:supplier_id, :product_id, :created_at, :updated_at)";
            
            $stmt = $conn->prepare($insert_method);
            $stmt->execute($supplier_data);
        }

        $response = [
            'success' => true,
            'message' => "<strong>$supplier_name</strong> has been updated into the database!"
        ];
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => "Error: " . $e->getMessage()
        ];
    }

    echo json_encode($response);
?>