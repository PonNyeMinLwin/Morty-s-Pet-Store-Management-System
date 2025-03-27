<?php
    include('connector.php');

    $id = $_GET['id'];

    // Getting the product information
    $stmt = $conn->prepare("SELECT supplier_name, suppliers.id FROM suppliers, product_suppliers WHERE product_suppliers.product_id=$id AND product_suppliers.supplier_id = suppliers.id");
    $stmt->execute();
    $suppliers_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($suppliers_list);
?>