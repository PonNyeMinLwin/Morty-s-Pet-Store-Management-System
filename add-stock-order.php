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
        <title>Add Stock Orders - Morty's Pet Store Management System</title>
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
                                <h1 class="columnHeader"><i class="fa-solid fa-tags"></i> Product Orders</h1> 
                                <div>
                                    <form action="database/save-function.php" method="POST">
                                        <div class="rightButtons">
                                            <button type="button" class="orderBtn addStockOrderBtn" id="addStockOrderBtn">
                                                <i class="fa-solid fa-file-circle-plus"></i> 
                                                Add New Product Order
                                            </button>
                                        </div>

                                        <div id="newStockOrder">
                                            <h3 id="noProductData" style="color: #cc7e7e; text-align: center; font-weight: bold;">
                                                No Current Product Orders!
                                            </h3>
                                        </div>

                                        <div class="rightButtons">
                                            <button type="submit" class="orderBtn submitStockOrderBtn">
                                                <i class="fa-solid fa-cart-plus"></i> 
                                                Submit Order
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <?php 
                                    if(isset($_SESSION['response'])) {
                                        $response_message = $_SESSION['response']['message'];
                                        $is_success = $_SESSION['response']['success'];
                                ?>
                                    <div class="responseMessage">
                                        <p class="<?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                            <?= $response_message ?>
                                        </p>
                                    </div>
                                <?php unset($_SESSION['response']); } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('prefabs/script-footer-links.php'); ?>

    <script>
        var products = <?= $products ?>;
        var count = 0;
        
        function script() {
            var t = this;

            let productSelections = '\
                <div>\
                    <label for="product_name">Product Name</label>\
                    <select class="productNameSelectionBox" name="products[]" id="product_name">\
                        <option value="">Select Product</option>\
                        INSERTPRODUCTHERE\
                    </select>\
                    <button class="removeOrderBtn"><i class="fa-solid fa-trash-can"></i> Delete Order</button>\
                </div>';
                
            this.initialize = function() {
                this.registerEvents();
                this.populateProductSelections();
            },

            this.populateProductSelections = function() {
                let productList = '';

                products.forEach((product) => {
                    productList += '<option value="' + product.id + '">' + product.product_name + '</option>';
                });
                
                productSelections = productSelections.replace('INSERTPRODUCTHERE', productList);
            },
            
            this.registerEvents = function() {
                document.addEventListener('click', function(e) {
                    targetElement = e.target;

                    // Adding a new stock order when 'add-product-order' button is clicked
                    if(targetElement.id === 'addStockOrderBtn') {
                        document.getElementById('noProductData').style.display = 'none';

                        let newStockOrderContainer = document.getElementById('newStockOrder');
                        newStockOrder.innerHTML += '\
                            <div class="productOrderRow">\
                                '+ productSelections +'\
                                <div class="supplierQuantityRows" id="sQRows-'+ count + '"data-counter="'+ count +'"></div>\
                            </div>';
                        
                        count++;
                    }

                    // Deleting a stock order when detele button is clicked
                    if(targetElement.classList.contains('removeOrderBtn')) {
                        targetElement.closest('div.productOrderRow').remove();
                    }

                });

                document.addEventListener('change', function(e) {
                    targetElement = e.target;

                    // Updating the suppliers selections when a product is chosen
                    if(targetElement.classList.contains('productNameSelectionBox')) {
                        let id = targetElement.value;

                        if(!id.length) return;

                        let sQRowId = targetElement.closest('div.productOrderRow').querySelector('.supplierQuantityRows').dataset.counter;
                        
                        $.get('database/get-product-supplier-info.php', {id: id}, function(data) {
                            t.populateSupplierSelections(data, sQRowId);
                        }, 'json');
                    }
                });
            },

            this.populateSupplierSelections = function(data, sQRowId) {
                let supplierQuantityRows = '';

                data.forEach((supplier) => {
                    supplierQuantityRows += '\
                        <div class="row">\
                            <div style="width: 30%;"><p class="supplierName">'+ supplier.supplier_name +'</p></div>\
                            <div style="width: 50%;">\
                                <label for="orderCount">Order Quantity:</label>\
                                <input type="number" class="addUserInput orderQtyCount" placeholder=" 0" id="orderCount" name="orderCount['+ sQRowId +']['+ supplier.id +']" />\
                            </div>\
                        </div>'; 
                });

                // Attaching the supplier selections to the product order row
                let sQRow = document.getElementById('sQRows-' + sQRowId);
                sQRow.innerHTML = supplierQuantityRows;
            }
        }

        var script = new script();
        script.initialize();
    </script>
    </body>
</html>