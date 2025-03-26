<?php
    // Starting the session
    session_start();

    // Capturing the columns from the database 
    include('database_columns.php');

    // Capturing the table name from the session
    $table_name = $_SESSION['table'];
    $columns = $database_table_columns[$table_name];

    // Looping through the columns to assign values to the table
    $user_input_array = [];
    $user = $_SESSION['user'];
    
    foreach($columns as $column) {
        if(in_array($column, ['created_at', 'updated_at'])) $value = date('Y-m-d H:i:s'); 
        else if ($column == 'created_by') $value = $user['id'];
        else if ($column == 'password') $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
        else if ($column == 'img') {
            // Uploading and moving image to directory
            $dir = "../inputs/product-images/";

            $file_data = $_FILES[$column];
            $file_name = $file_data['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = 'product-img-' . time() . '.' . $file_ext;
            $check = getimagesize($file_data['tmp_name']);

            // Checking the uploaded image and moving to directory
            if($check) {
                if(move_uploaded_file($file_data['tmp_name'], $dir . $file_name)) {
                    // Saving the file name to the database
                    $value = $file_name;
                } else {
                    $value = '';
                }
            } else {
                $value = '';
            }
        }
        else $value = isset($_POST[$column]) ? $_POST[$column] : ''; 

        $user_input_array[$column] = $value;
    }

    $table_columns = implode(", ", array_keys($user_input_array));
    $table_values = ':' . implode(", :", array_keys($user_input_array));

    // Assigning values to the 'Users' table
    //$first_name = $_POST['first_name'];
    //$last_name = $_POST['last_name'];
    //$email = $_POST['email'];
    //$password = $_POST['password'];
    //$encrypted = password_hash($password, PASSWORD_DEFAULT);

    // Adding the values to the database
    try {
        $insert_method = "INSERT INTO $table_name($table_columns) VALUES ($table_values)";
        
        include('connector.php');

        $stmt = $conn->prepare($insert_method);
        $stmt->execute($user_input_array);

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