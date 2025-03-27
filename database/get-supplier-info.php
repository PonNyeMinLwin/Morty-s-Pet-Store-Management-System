<?php
    include('connector.php');

    $id = $_GET['id'];
 
    $stmt = $conn->prepare("SELECT * FROM suppliers WHERE id=$id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Getting the product information
    $stmt = $conn->prepare("SELECT product_name, products.id FROM products, product_suppliers WHERE product_suppliers.supplier_id=$id AND product_suppliers.product_id = products.id");
    $stmt->execute();
    $products_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $row['products_list'] = array_column($products_list, 'id');
    echo json_encode($row);
?>