<?php
    include('connector.php');

    // Getting the list of all supplier names 
    $stmt_supplier = $conn->prepare("SELECT id, supplier_name FROM suppliers");
    $stmt_supplier->execute();
    $sIdRows = $stmt_supplier->fetchAll();

    $stmt_product = $conn->prepare("SELECT id, product_name FROM products");                                                        
    $stmt_product->execute();
    $pIdRows = $stmt_product->fetchAll();

    $categories = [];
    $results = [];
    $products = [];
    $product_count = [];

    // Populate product names
    foreach ($pIdRows as $pRow) {
        $products[] = $pRow['product_name'];
    }

    // Loop through suppliers and get product counts for each supplier
    foreach ($sIdRows as $sRow) {
        $supplier_id = $sRow['id'];
        $categories[] = $sRow['supplier_name'];

        $supplier_product_counts = [];

        foreach ($pIdRows as $pRow) {
            $product_id = $pRow['id'];

            $stmt_count = $conn->prepare("SELECT COUNT(*) as p_count FROM purchase_order WHERE supplier_id = :supplier_id AND product_id = :product_id");
            $stmt_count->execute(['supplier_id' => $supplier_id, 'product_id' => $product_id]);
            $count_row = $stmt_count->fetch();

            $supplier_product_counts[] = (int) $count_row['p_count'];
        }

        $product_count[] = $supplier_product_counts; // Add this supplier's product counts to the array
    }
?>