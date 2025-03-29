<?php
    $orders = $_POST['payload'];

    include('connector.php');
    
    try {
        foreach($orders as $order) {
            $amt_received = (int) $order['amtLeft'];

            // Use this if statement for Add New Stock Order page as well
            if($amt_received > 0) {
                $curr_amt = (int) $order['amtGot'];
                $status = $order['status'];
                $id = $order['id'];
                $amt_ordered = (int) $order['amtOrdered'];
                $product_id = (int) $order['product_id'];

                // Updating according to user input's values
                $updated_amt = $curr_amt + $amt_received;
                $amt_remaining = $amt_ordered - $updated_amt;
            
                $update_method = "UPDATE purchase_order SET stock_received=?, status=?, stock_remaining_in_order=? WHERE id=?";
                $stmt = $conn->prepare($update_method);
                $stmt->execute([$updated_amt, $status, $amt_remaining, $id]);

                // Addding to supplier_transactions (and stock?)
                $order_receipts = ['order_id' => $id, 'amount' => $amt_received, 'order_completed_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];

                $insert_method = "INSERT INTO supplier_transactions (order_id, amount, order_completed_at, updated_at) VALUES (:order_id, :amount, :order_completed_at, :updated_at)";
                $stmt = $conn->prepare($insert_method);
                $stmt->execute($order_receipts);

                $stmt = $conn->prepare("SELECT products.stock FROM products WHERE id = $product_id");                    
                $stmt->execute();
                $product_stock_amt = $stmt->fetch();

                $current_stock = (int) $product_stock_amt['stock'];
                $edited_stock = $current_stock + $amt_received;

                $update_method = "UPDATE products SET stock=? WHERE id=?";

                $stmt = $conn->prepare($update_method);
                $stmt->execute([$edited_stock, $product_id]);
            }
        }
                 
        $response = [
            'success' => true, 
            'message' => 'Purchase order has been successfully updated!'
        ];

    } catch (\Exception $e) {
        $response = [
            'success' => false, 
            'message' => $e->getMessage()
        ];
    }
    echo json_encode($response); 
?>