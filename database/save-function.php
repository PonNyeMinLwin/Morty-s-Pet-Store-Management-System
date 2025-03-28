<?php
    session_start();

    $data = $_POST;
    $products = $data['products'];
    $order_quantity = array_values($data['orderCount']); 

    $data_arr = [];

    // Reorganising the data to be saved in the database
    foreach($products as $key => $product_id) {
        if(isset($order_quantity[$key])) $data_arr[$product_id] = $order_quantity[$key];
    }

    // Including the database connector
    include('connector.php');

    $batch = time();
    $success = false;

    // Saving the data to the database
    try {
        foreach($data_arr as $product_id => $quantity) {
            foreach($quantity as $supplier_id => $order_quantity) {
                // Inserting this data to the database
                $values = [
                    'supplier_id' => $supplier_id, 
                    'product_id' => $product_id, 
                    'stock_ordered' => $order_quantity,
                    'status' => 'PENDING',
                    'batch' => $batch,
                    'created_by' => $_SESSION['user']['id'],
                    'created_at' => date('Y-m-d H:i:s'), 
                    'updated_at' => date('Y-m-d H:i:s')
                ];
    
                $insert_method = "INSERT INTO purchase_order(supplier_id, product_id, stock_ordered, status, batch, created_by, created_at, updated_at) VALUES (:supplier_id, :product_id, :stock_ordered, :status, :batch, :created_by, :created_at, :updated_at)";
                $stmt = $conn->prepare($insert_method);
                $stmt->execute($values);
            }
        }
        $success = true;
        $message = '';
    } catch (\Exception $e) { $message = $e->getMessage(); }

    $_SESSION['response'] = [
        'success' => $success,
        'message' => $success ? 'Product order has been successfully placed!' : $message
    ];

    header('location: ../add-stock-order.php');
?>