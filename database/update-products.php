<?php
    include('connector.php');

    // Getting the new product information from the user
    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];
    $info = $_POST['info'];
    $price = $_POST['price'];
    $id = $_POST['id'];
    $curr_img = $_POST['current_img'] ?? null;


    // Uploading and moving image to directory
    $dir = "../inputs/product-images/";
    $tmp_file_name = $curr_img;

    if(isset($_FILES['img']) && $_FILES['img']['size'] > 0) {
        $file_data = $_FILES['img'];
        $file_name = $file_data['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_name = 'product-img-' . time() . '.' . $file_ext;

        $check = getimagesize($file_data['tmp_name']);

        // Checking the uploaded image and moving to directory
        if ($check && move_uploaded_file($file_data['tmp_name'], $dir . $file_name)) {
            $tmp_file_name = $file_name; // Replace with new image name
        }
    }

    try {
        // Saving the new information and updating the 'View Products' table
        $update_method = "UPDATE products SET product_name=?, product_type=?, img=?, info=?, price=? WHERE id=?";
        
    
        $stmt = $conn->prepare($update_method);
        $stmt->execute([$product_name, $product_type, $tmp_file_name, $info, $price, $id]);

        $response = [
            'success' => true,
            'message' => "<strong>$product_name</strong> has been updated into the database!"
        ];
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => "Error processing request!"
        ];
    }

    echo json_encode($response);
?>