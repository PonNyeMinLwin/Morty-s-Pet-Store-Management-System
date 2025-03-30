<?php
    include('connector.php');

    // Get all suppliers
    $stmt_supplier = $conn->prepare("SELECT id, supplier_name FROM suppliers");
    $stmt_supplier->execute();
    $sIdRows = $stmt_supplier->fetchAll();

    // Get all products and their stock
    $stmt_product = $conn->prepare("SELECT id, product_name, stock FROM products");
    $stmt_product->execute();
    $pIdRows = $stmt_product->fetchAll();

    $categories = []; // Supplier names
    $products = [];   // Product names
    $product_count = []; // Total stock of each product
    $supplier_stock_data = []; // Stock supplied by each supplier for each product

    // Populate product names and total stock
    foreach ($pIdRows as $pRow) {
        $products[] = $pRow['product_name'];
        $product_count[] = (int) $pRow['stock'];
    }

    // Populate supplier names and initialize supplier stock data
    foreach ($sIdRows as $sRow) {
        $categories[] = $sRow['supplier_name'];
        $supplier_stock_data[$sRow['id']] = array_fill(0, count($products), 0); // Initialize with 0 for each product
    }

    // Fetch stock supplied by each supplier for each product
    foreach ($sIdRows as $sRow) {
        $supplier_id = $sRow['id'];

        foreach ($pIdRows as $pRow) {
            $product_id = $pRow['id'];
            $product_index = array_search($pRow['product_name'], $products);

            // Query to get the stock supplied by this supplier for this product
            $stmt = $conn->prepare("
                SELECT SUM(stock_received) as total_stock
                FROM purchase_order
                WHERE supplier_id = :supplier_id AND product_id = :product_id
            ");
            $stmt->execute(['supplier_id' => $supplier_id, 'product_id' => $product_id]);
            $result = $stmt->fetch();

            // Update supplier stock data
            $supplier_stock_data[$supplier_id][$product_index] = (int) $result['total_stock'];
        }
    }

    // Convert supplier_stock_data to a format suitable for Highcharts
    $supplier_series = [];
    foreach ($sIdRows as $sRow) {
        $supplier_series[] = [
            'name' => $sRow['supplier_name'],
            'data' => $supplier_stock_data[$sRow['id']]
        ];
    }
?>