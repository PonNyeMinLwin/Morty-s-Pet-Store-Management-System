<?php
    // Starting the session
    session_start();

    // Capturing the columns from the database 
    include('database-columns.php');

    // Capturing the table name from the session
    $table_name = $_SESSION['table'];
    $columns = $database_table_columns[$table_name];

    // Looping through the columns to assign values to the table
    $user_input_array = [];
    $user = $_SESSION['user'];
    
    foreach($columns as $column) {
        if(in_array($column, ['created_at', 'updated_at'])) $value = date('Y-m-d H:i:s'); 
        else if ($column == 'created_by') $value = $user['id'];
        else if ($column == 'password') $value = $_POST[$column];
        else if ($column == 'img') {
            // Uploading and moving image to directory
            $dir = "../inputs/product-images/";
            $file_data = $_FILES[$column];
            
            $value = null;
            $file_data = $_FILES['img'];

            if($file_data['tmp_name'] !== '') {
                $file_name = $file_data['name'];
                $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $file_name = 'product-img-' . time() . '.' . $file_ext;
        
                $check = getimagesize($file_data['tmp_name']);
        
                // Checking the uploaded image and moving to directory
                if ($check && move_uploaded_file($file_data['tmp_name'], $dir . $file_name)) {
                    $value = $file_name; // Replace with new image name
                }
            }
        }
        else $value = isset($_POST[$column]) ? $_POST[$column] : ''; 

        $user_input_array[$column] = $value;
    }

    $table_columns = implode(", ", array_keys($user_input_array));
    $table_values = ':' . implode(", :", array_keys($user_input_array));

    // Adding the values to the database
    try {
        $insert_method = "INSERT INTO $table_name($table_columns) VALUES ($table_values)";
        
        include('connector.php');

        $stmt = $conn->prepare($insert_method);
        $stmt->execute($user_input_array);

        // Adding suppliers to the products table
        if($table_name === 'products') {
            $product_id = $conn->lastInsertId();

            $suppliers = isset($_POST['suppliers']) ? $_POST['suppliers'] : [];
            if($suppliers) {
                // Looping through the suppliers and adding to the database
                foreach($suppliers as $supplier) {
                    $supplier_data = ['supplier_id' => $supplier, 'product_id' => $product_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                    $insert_supplier_method = "INSERT INTO product_suppliers(supplier_id, product_id, created_at, updated_at) VALUES (:supplier_id, :product_id, :created_at, :updated_at)";
                    
                    $stmt = $conn->prepare($insert_supplier_method);
                    $stmt->execute($supplier_data);
                }
            }
        }

        $response = [
            'success' => true,
            'message' => 'Added to the database!'
        ];
    } catch(PDOException $e) {
        $response = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }

    $_SESSION['response'] = $response;
    header('Location: ../' . $_SESSION['redirect_to']);
?>