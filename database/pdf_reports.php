<?php
    require('fpdf186/fpdf.php');

    class PDF extends FPDF {
        function __construct() {
            parent::__construct('L');
        }
        // Colored table
        function FancyTable($header, $data, $row_height = 26) {
            // Colors, line width and bold font
            $this->SetFillColor(255,0,0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128,0,0);
            $this->SetLineWidth(.3);
            $this->SetFont('','B');

            // Header
            $width_total = 0;

            foreach($header as $header_key => $header_value) {
                $this->Cell($header_value['width'], 10, strtoupper($header_key), 1, 0, 'C', true);
            }
            $this->Ln();

            // Color and font restoration
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');

            // Data
            $img_y_pos = 40;
            $header_keys = array_keys($header);
            foreach($data as $row) {
                foreach($header_keys as $header_key) {
                    $content = $row[$header_key]['content'];
                    $width = $header[$header_key]['width'];
                    $align = $row[$header_key]['align'] ?? 'C';

                    if ($header_key == 'img') {
                        $file_path = '.././inputs/product-images/' . $content;

                        // Validate if the file is a valid JPEG
                        if (file_exists($file_path) && exif_imagetype($file_path) === IMAGETYPE_JPEG) {
                            $this->Image($file_path, 27, $img_y_pos, 24, 26);
                            $content = ''; // Clear content since the image is displayed
                        } else {
                            $content = 'Invalid Image!';
                        }
                    }

                    $this->Cell($width, $row_height, $content, 'LRBT', 0, $align);
                }

                $this->Ln();
                $img_y_pos += 26; // Move the image position down for the next row
            }

            // Closing line
            $this->Cell(array_sum(array_column($header, 'width')), 0, '', 'T');
        }
    }

    $report_type = $_GET['report'];
    $report_headers = ['productReport' => 'Inventory Overview', 'orderReport' => 'Stock Order Analysis', 'supplierReport' => 'Suppliers Analysis', 'deliveryReport' => 'Delivery History Analysis'];
    $row_height = 26;

    include('connector.php');

    // Exporting the Products Report table and values from database
    if($report_type == 'productReport') {
        $header = [
            'id' => ['width' => 10],
            'img' => ['width' => 40],
            'product_name' => ['width' => 40],
            'stock' => ['width' => 15],
            'info' => ['width' => 50],
            'price' => ['width' => 15],
            'created_by' => ['width' => 20],
            'created_at' => ['width' => 45],
            'updated_at' => ['width' => 45]
        ];

        // Loading data from products table
        $stmt = $conn->prepare("SELECT *, products.id as product_id FROM products INNER JOIN users ON products.created_by = users.id ORDER BY products.created_at DESC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $products = $stmt->fetchAll();

        $data = [];

        foreach($products as $product) {
            $product['created_by'] = $product['first_name'] . ' ' . $product['last_name'];
            unset($product['first_name'], $product['last_name'], $product['password'], $product['email']);

            // Format the data correctly
            $data[] = [
                'id' => ['content' => $product['product_id'], 'align' => 'C'],
                'img' => ['content' => $product['img'], 'align' => 'C'],
                'product_name' => ['content' => $product['product_name'], 'align' => 'C'],
                'stock' => ['content' => number_format($product['stock']), 'align' => 'C'],
                'info' => ['content' => $product['info'], 'align' => 'C'],
                'price' => ['content' => $product['price'], 'align' => 'C'],
                'created_by' => ['content' => $product['created_by'], 'align' => 'C'],
                'created_at' => ['content' => date('M d, Y h:i:s A', strtotime($product['created_at'])), 'align' => 'C'],
                'updated_at' => ['content' => date('M d, Y h:i:s A', strtotime($product['updated_at'])), 'align' => 'C']
            ];
        }
    }

    // Exporting the Suppliers Report table and values from database
    if($report_type == 'supplierReport') {
        $header = [
            'id' => ['width' => 10],
            'supplier_name' => ['width' => 40],
            'supplier_location' => ['width' => 100],
            'email' => ['width' => 60],
            'created_by' => ['width' => 20],
            'created_at' => ['width' => 45]
        ];

        // Loading data from products table
        $stmt = $conn->prepare("SELECT suppliers.id as supplier_id, suppliers.supplier_name, suppliers.supplier_location, suppliers.email, suppliers.created_by, users.first_name, users.last_name, suppliers.created_at FROM suppliers INNER JOIN users ON suppliers.created_by = users.id ORDER BY suppliers.created_at ASC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $suppliers = $stmt->fetchAll();

        $data = [];

        foreach($suppliers as $supplier) {
            $supplier['created_by'] = $supplier['first_name'] . ' ' . $supplier['last_name'];
            
            // Format the data correctly
            $data[] = [
                'id' => ['content' => $supplier['supplier_id'], 'align' => 'C'],
                'supplier_name' => ['content' => $supplier['supplier_name'], 'align' => 'C'],
                'supplier_location' => ['content' => $supplier['supplier_location'], 'align' => 'C'],
                'email' => ['content' => $supplier['email'], 'align' => 'C'],
                'created_by' => ['content' => $supplier['created_by'], 'align' => 'C'],
                'created_at' => ['content' => date('M d, Y h:i:s A', strtotime($supplier['created_at'])), 'align' => 'C']
            ];
        }

        $row_height = 20;
    }

    // Exporting the Delivery Report table and values from database
    if($report_type == 'deliveryReport') {
        $header = [
            'order_completed_at' => ['width' => 50],
            'amount' => ['width' => 20],
            'product_name' => ['width' => 65],
            'supplier_name' => ['width' => 65],
            'batch' => ['width' => 40],
            'created_by' => ['width' => 40]
        ];

        // Loading data from products table
        $stmt = $conn->prepare("SELECT order_completed_at, amount, products.product_name, supplier_name, batch, first_name, last_name 
                FROM supplier_transactions, purchase_order, users, suppliers, products WHERE supplier_transactions.order_id = purchase_order.id 
                AND purchase_order.created_by = users.id AND purchase_order.supplier_id = suppliers.id AND purchase_order.product_id = products.id
                ORDER BY order_completed_at ASC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $orders = $stmt->fetchAll();

        $data = [];

        foreach($orders as $order) {
            $order['created_by'] = $order['first_name'] . ' ' . $order['last_name'];
            
            // Format the data correctly
            $data[] = [
                'order_completed_at' => ['content' => date('M d, Y h:i:s A', strtotime($order['order_completed_at'])), 'align' => 'C'],
                'amount' => ['content' => number_format($order['amount']), 'align' => 'C'],
                'product_name' => ['content' => $order['product_name'], 'align' => 'C'],
                'supplier_name' => ['content' => $order['supplier_name'], 'align' => 'C'],
                'batch' => ['content' => $order['batch'], 'align' => 'C'],
                'created_by' => ['content' => $order['created_by'], 'align' => 'C']
            ];
        }

        $row_height = 10;
    }

    // Exporting the Order Report table and values from database
    if($report_type == 'orderReport') {
        $header = [
            'id' => ['width' => 10],
            'stock_ordered' => ['width' => 20],
            'stock_received' => ['width' => 20],
            'stock_remaining' => ['width' => 20],
            'status' => ['width' => 25],
            'batch' => ['width' => 22],
            'supplier_name' => ['width' => 45],
            'product_name' => ['width' => 45],
            'order_made_at' => ['width' => 45],
            'created_by' => ['width' => 25]
        ];

        // Loading data from products table
        $stmt = $conn->prepare("SELECT purchase_order.id, purchase_order.stock_ordered, purchase_order.stock_received, purchase_order.stock_remaining_in_order as 'stock_remaining',
                purchase_order.status, purchase_order.batch, users.first_name, users.last_name, suppliers.supplier_name, products.product_name, purchase_order.created_at as 'order_made_at'
                    FROM purchase_order INNER JOIN users ON purchase_order.created_by = users.id 
                    INNER JOIN suppliers ON purchase_order.supplier_id = suppliers.id INNER JOIN products ON purchase_order.product_id = products.id
                    ORDER BY purchase_order.batch ASC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $deliveries = $stmt->fetchAll();

        $data = [];

        foreach($deliveries as $delivery) {
            $delivery['created_by'] = $delivery['first_name'] . ' ' . $delivery['last_name'];
            
            // Format the data correctly
            $data[] = [
                'id' => ['content' => $delivery['id'], 'align' => 'C'],
                'stock_ordered' => ['content' => number_format($delivery['stock_ordered']), 'align' => 'C'],
                'stock_received' => ['content' => number_format($delivery['stock_received']), 'align' => 'C'],
                'stock_remaining' => ['content' => number_format($delivery['stock_remaining']), 'align' => 'C'],
                'status' => ['content' => $delivery['status'], 'align' => 'C'],
                'batch' => ['content' => $delivery['batch'], 'align' => 'C'],
                'supplier_name' => ['content' => $delivery['supplier_name'], 'align' => 'C'],
                'product_name' => ['content' => $delivery['product_name'], 'align' => 'C'],
                'order_made_at' => ['content' => date('M d, Y h:i:s A', strtotime($delivery['order_made_at'])), 'align' => 'C'],
                'created_by' => ['content' => $delivery['created_by'], 'align' => 'C']
            ];
        }

        $row_height = 10;
    }

    $pdf = new PDF();
    $pdf->SetFont('Arial','', 16);
    
    $pdf->AddPage();

    $pdf->Cell(120);
    $pdf->Cell(30, 10, $report_headers[$report_type], 0, 0, 'C');
    $pdf->SetFont('Arial','', 10);
    $pdf->Ln();
    $pdf->Ln();

    $pdf->FancyTable($header,$data, $row_height);
    $pdf->Output();
?>