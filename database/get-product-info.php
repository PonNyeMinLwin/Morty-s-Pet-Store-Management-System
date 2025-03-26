<?php
    include('connector.php');

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT * FROM products WHERE id=$id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Invalid or missing ID']);
    }
?>