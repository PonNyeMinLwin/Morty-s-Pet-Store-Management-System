<?php
    $orders = $_POST['payload'];

    include('connector.php');

    try {
        foreach($orders as $order) {
            $amt_received = (int) $order['amtGot'];
            $status = $order['status'];
            $id = $order['id'];
            $amt_ordered = (int) $order['amtOrdered'];
        
            $amt_remaining = $amt_ordered - $amt_received;
    
            $update_method = "UPDATE purchase_order SET stock_received=?, status=?, stock_remaining_in_order=? WHERE id=?";
            $stmt = $conn->prepare($update_method);
            $stmt->execute([$amt_received, $status, $amt_remaining, $id]);
        }

        $response = ['success' => true, 'message' => 'Purchase order has been successfully updated!'];

    } catch (\Exception $e) {
        $response = ['success' => false, 'message' => $e->getMessage()];
    }

    echo json_encode($response); 
?>