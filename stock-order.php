<?php
    // Starting the session
    session_start();
    if(!isset($_SESSION['user'])) header('location: index.php');

    // Getting all products from the database
    $target_table = 'products';
    $products = include('database/show-function.php');
    $products = json_encode($products);
?>
<html>
    <head>
        <title>Stock Orders - Morty's Pet Store Management System</title>
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
                                <h1 class="columnHeader"><i class="fa-solid fa-tags"></i> Order Product Stocks</h1> 
                                <div>
                                    <div class="rightButtons">
                                        <button class="orderBtn addStockOrderBtn" id="addStockOrderBtn"><i class="fa-solid fa-file-circle-plus"></i> Add New Stock Order</button>
                                    </div>
                                    <div id="orderStockLists">
                                        <div class="productOrderRow">
                                            <div>
                                                <label for="product_name">Product Name</label>
                                                <select class="productNameSelectionBox" name="product_name" id="product_name">
                                                    <option value="">Select Product...</option>
                                                </select>
                                            </div>

                                            <div class="supplierQuantityRows">
                                                <div class="row">
                                                    <div style="width: 20%;">
                                                        <p class="supplierName">Supplier 1</p>
                                                    </div>
                                                    <div style="width: 80%;">
                                                        <label for="orderCount">Order Quantity:</label>
                                                        <input type="number" class="addUserInput" placeholder="0" id="orderCount" name="orderCount" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div style="width: 20%;">
                                                        <p class="supplierName">Supplier 2</p>
                                                    </div>
                                                    <div style="width: 80%;">
                                                        <label for="orderCount">Order Quantity:</label>
                                                        <input type="number" class="addUserInput" placeholder="0" id="orderCount" name="orderCount" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div style="width: 20%;">
                                                        <p class="supplierName">Supplier 3</p>
                                                    </div>
                                                    <div style="width: 80%;">
                                                        <label for="orderCount">Order Quantity:</label>
                                                        <input type="number" class="addUserInput" placeholder="0" id="orderCount" name="orderCount" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rightButtons">
                                        <button class="orderBtn submitStockOrderBtn"><i class="fa-solid fa-cart-plus"></i> Submit Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('prefabs/script-footer-links.php'); ?>
        <script>
            var products = <?= $products ?>;
        </script>
    </body>
</html>