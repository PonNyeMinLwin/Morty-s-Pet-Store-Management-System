<?php
    include('connector.php');

    $stmt = $conn->prepare("SELECT amount, order_completed_at FROM supplier_transactions ORDER BY order_completed_at ASC");
    $stmt->execute();
    $resultRows = $stmt->fetchAll();

    $values = [];

    foreach ($resultRows as $row) {
        $date = date('Y-m-d', strtotime($row['order_completed_at']));
        $values[$date] = isset($values[$date]) ? $values[$date] + (int) $row['amount'] : (int) $row['amount'];
    }

    // Returning data as an array to suit Highcharts
    $line_x_values = array_keys($values);
    $line_y_values = array_values($values);
?>