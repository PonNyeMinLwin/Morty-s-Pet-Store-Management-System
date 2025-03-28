<?php
    // Starting the session
    session_start();
    if(!isset($_SESSION['user'])) header('location: index.php');

    $target_table = 'suppliers';
    $suppliers = include('database/show-function.php');
?>

<html>
    <head>
        <title>View Stock Orders - Morty's Pet Store Management System</title>
        <?php include('prefabs/script-header-links.php'); ?>
    </head>
    <body>
        <div id="dashBoardMainContainer">
            <?php include('prefabs/dashboard-sidebar.php') ?>
            <div class="dashBoardContentContainer" id="dashBoardContentContainer">
                <?php include('prefabs/dashboard-top-nav-bar.php') ?>
                <div class="dashBoardContent">
                    <div class="contentMainBody">
                        <div class="row">
                            <div class="column column-12">
                                <h1 class="columnHeader"><i class="fa-solid fa-list"></i> List of Product Orders</h1>
                                <div class="userListContainer">
                                    <div class="orderNumContainer">
                                        <?php
                                            $stmt = $conn->prepare(
                                                "SELECT purchase_order.id, products.product_name, purchase_order.stock_ordered, users.first_name, users.last_name, 
                                                        purchase_order.batch, purchase_order.stock_remaining_in_order, purchase_order.stock_received, 
                                                        suppliers.supplier_name, purchase_order.status, purchase_order.created_at, purchase_order.updated_at
                                                FROM purchase_order, suppliers, products, users
                                                WHERE purchase_order.supplier_id = suppliers.id AND purchase_order.product_id = products.id 
                                                AND purchase_order.created_by = users.id
                                                ORDER BY purchase_order.stock_ordered ASC"
                                            );                    
                                            
                                            $stmt->execute();
                                            $value_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            $stock_order_data = [];

                                            // Pairing the batch number with the values
                                            foreach($value_rows as $value_row) {
                                                $stock_order_data[$value_row['batch']][] = $value_row; 
                                            }   
                                        ?>

                                        <?php
                                            foreach($stock_order_data as $batch_no => $product_orders) {
                                        ?>
                                        <div class="orderNum" id="orderNum-<?= $batch_no ?>">
                                            <p>Order #:<?= $batch_no ?></p>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Product Name</th>
                                                        <th>Amt</th>
                                                        <th>Amt Received</th>
                                                        <th>Amt Remaining</th>
                                                        <th>Status</th>
                                                        <th>Supplier Name</th>
                                                        <th>Ordered By</th>
                                                        <th>Ordered At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($product_orders as $key => $product_order) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $key + 1 ?></td>
                                                        <td class="product"><?= $product_order['product_name'] ?></td>
                                                        <td class="amt_order"><?= $product_order['stock_ordered'] ?></td>
                                                        <td class="amt_get"><?= $product_order['stock_received'] ?></td>
                                                        <td class="amt_left"><?= $product_order['stock_remaining_in_order'] ?></td>
                                                        <td class="amt_status"><span class="status status-<?= $product_order['status'] ?>"><?= $product_order['status'] ?></span></td>
                                                        <td class="supplier"><?= $product_order['supplier_name'] ?></td>
                                                        <td class="name"><?= $product_order['first_name'] . ' ' . $product_order['last_name'] ?></td>
                                                        <td class="date_create">
                                                            <?= $product_order['created_at'] ?>
                                                            <input type="hidden" class="batch_id" value="<?= $product_order['id'] ?>">
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table> 
                                            <div class="stockOrderButtonContainers rightButtons">
                                                <button class="btn editOrderBtn" data-id="<?= $batch_no ?>"><i class="fa-solid fa-pencil"></i> Edit Order</button>
                                            </div>  
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php 
            include('prefabs/script-footer-links.php'); 
        ?>
    
        <script>
            function script() {
                var t = this;

                // Initialising events
                this.initialize = function() {
                    this.registerEvents();
                },

                // Looking for clicks on certain parts of the page
                this.registerEvents = function() {
                    document.addEventListener('click', function(e) {
                        targetElement = e.target;

                        if(targetElement.classList.contains('editOrderBtn')) {
                            e.preventDefault();

                            batchData = 'orderNum-' + targetElement.dataset.id;

                            // Getting all purchase order data to be edited
                            productList = document.querySelectorAll('#' + batchData + ' .product');
                            amt_order = document.querySelectorAll('#' + batchData + ' .amt_order');
                            amt_get = document.querySelectorAll('#' + batchData + ' .amt_get');
                            //amt_left = document.querySelectorAll('#' + batchData + ' .amt_left');
                            status = document.querySelectorAll('#' + batchData + ' .amt_status');
                            supplier = document.querySelectorAll('#' + batchData + ' .supplier');

                            // Putting them in an array
                            orderDataArr = [];
                            for(i = 0; i < productList.length; i++) {
                                orderDataArr.push({
                                    product: productList[i].innerText,
                                    amt_order: amt_order[i].innerText,
                                    amt_get: amt_get[i].innerText,
                                    //amt_left: amt_left[i].innerText,
                                    status: status[i].innerText,
                                    supplier: supplier[i].innerText
                                });
                            }

                            productList.forEach((product, index) => {
                                orderDataArr[index]['product'] = product.innerText;
                            });  
                        }
                    });
                }
            }

            var script = new script;
            script.initialize();
        </script>  
    </body>
</html>