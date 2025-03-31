<?php
    require('fpdf186/fpdf.php');

    class PDF extends FPDF {
        function __construct() {
            parent::__construct('L');
        }
        // Colored table
        function FancyTable($header, $data) 
        {
            // Colors, line width and bold font
            $this->SetFillColor(255,0,0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128,0,0);
            $this->SetLineWidth(.6);
            $this->SetFont('','B');

            // Header
            $w = array(10, 40, 40, 15, 70, 15, 20, 45, 45);
            for($i=0;$i<count($header);$i++)
                $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
            $this->Ln();

            // Color and font restoration
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');

            // Data
            $fill = false;
            foreach($data as $row)
            {
                $this->Cell($w[0],6,$row[0],'LR',0,'C',$fill);
                $this->Cell($w[1],6,$row[1],'LR',0,'C',$fill);
                $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
                $this->Cell($w[3],6,$row[3],'LR',0,'C',$fill);
                $this->Cell($w[4],6,$row[4],'LR',0,'C',$fill);
                $this->Cell($w[5],6,$row[5],'LR',0,'C',$fill);
                $this->Cell($w[6],6,$row[6],'LR',0,'C',$fill);
                $this->Cell($w[7],6,$row[7],'LR',0,'L',$fill);
                $this->Cell($w[8],6,$row[8],'LR',0,'L',$fill);
                $this->Ln();
                $fill = !$fill;
            }
            // Closing line
            $this->Cell(array_sum($w),0,'','T');
        }
    }

    $report_type = $_GET['report'];
    $report_headers = ['productReport' => 'Product Type Analysis', 'orderReport' => 'Order Report', 'supplierReport' => 'Supplier Report', 'inventoryReport' => 'Inventory Report'];

    include('connector.php');

    if($report_type == 'productReport') {
        $header = array('ID', 'Image', 'Product', 'Stock', 'Description', 'Price', 'Created By', 'Created At', 'Updated At');

        // Loading data from products table
        $stmt = $conn->prepare("SELECT *, products.id as product_id FROM products INNER JOIN users ON products.created_by = users.id ORDER BY products.created_at DESC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $products = $stmt->fetchAll();

        $is_header = true;
        $data = [];

        foreach($products as $product) {
            $product['created_by'] = $product['first_name'] . ' ' . $product['last_name'];
            unset($product['first_name'], $product['last_name'], $product['password'], $product['email']);

            // This function formats the data and gets rid of any whitespaces in data values (taken from the original code)
            array_walk($product, function(&$str) {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            });

            $data[] = [
                $product['product_id'], 
                $product['img'],
                $product['product_name'], 
                number_format($product['stock']), 
                $product['info'], 
                $product['price'], 
                $product['created_by'], 
                date('M d, Y h:i:s A', strtotime($product['created_at'])), 
                date('M d, Y h:i:s A', strtotime($product['updated_at']))
            ];
        }
    }

    $pdf = new PDF();
    $pdf->SetFont('Arial','', 16);
    
    $pdf->AddPage();

    $pdf->Cell(120);
    $pdf->Cell(30, 10, $report_headers[$report_type], 0, 0, 'C');
    $pdf->SetFont('Arial','', 10);
    $pdf->Ln();
    $pdf->Ln();

    $pdf->FancyTable($header,$data);
    $pdf->Output();
?>