<?php
    include('connector.php');

    $id = $_GET['id'];

    // Getting the product information 
    $stmt = $conn->prepare("SELECT * FROM products WHERE id=$id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Getting the suppliers information
    $stmt = $conn->prepare("SELECT supplier_name, suppliers.id FROM suppliers, product_suppliers WHERE product_suppliers.product_id=$id AND product_suppliers.supplier_id = suppliers.id");
    $stmt->execute();
    $suppliers_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $row['suppliers_list'] = array_column($suppliers_list, 'id');
    echo json_encode($row);
?>