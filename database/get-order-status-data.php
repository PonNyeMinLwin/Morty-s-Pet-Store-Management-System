<?php
    include('connector.php');

    $status_list = ['PENDING', 'COMPLETED', 'CANCELLED'];
    $result_list = [];

    // Looping through the status list to get the count of each status
    foreach($status_list as $status) {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM purchase_order WHERE purchase_order.status='" . $status . "'");
        $stmt->execute();
        $row = $stmt->fetch();

        $count = $row['count'];

        $result_list[] = ['name' => strtoupper($status), 'y' => (int) $count];
    }
?>