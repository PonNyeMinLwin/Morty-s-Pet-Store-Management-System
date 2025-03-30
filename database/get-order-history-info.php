<?php
    include('connector.php');

    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM supplier_transactions WHERE order_id=$id ORDER BY order_completed_at DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    echo json_encode($stmt->fetchAll());
?>