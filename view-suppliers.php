<?php
    // Starting the session
    session_start();
    if(!isset($_SESSION['user'])) header('location: index.php');

    $target_table = 'suppliers';
    $suppliers = include('database/show-function.php');
?>

<html>
    <head>
        <title>View Suppliers - Morty's Pet Store Management System</title>
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
                                <h1 class="columnHeader"><i class="fa-solid fa-list"></i> List of Suppliers</h1>
                                <div class="userListContainer">
                                    <div class="usersList">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Supplier Name</th>
                                                    <th>Supplier Location</th>
                                                    <th>Email</th>
                                                    <th width="20%">Products</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($suppliers as $index => $supplier) { ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= $supplier['supplier_name'] ?></td>
                                                        <td><?= $supplier['supplier_location'] ?></td>
                                                        <td><?= $supplier['email'] ?></td>
                                                        <td>
                                                            <?php
                                                                $products_made_by_list = '';

                                                                $s_id = $supplier['id'];
                                                                $stmt = $conn->prepare("SELECT product_name FROM products, product_suppliers WHERE product_suppliers.supplier_id=$s_id AND product_suppliers.product_id = products.id");
                                                                
                                                                $stmt->execute();
                                                                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                                if($row) {
                                                                    $product_arr_list = array_column($row, 'product_name');
                                                                    $products_made_by_list = '<li>' . implode("</li><li>", $product_arr_list);
                                                                }

                                                                echo $products_made_by_list;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $u_id = $supplier['created_by'];
                                                                $stmt = $conn->prepare("SELECT * FROM users WHERE id=$u_id");
                                                                $stmt->execute();
                                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                                
                                                                $product_creator = $row['first_name'] . ' ' . $row['last_name'];
                                                                echo $product_creator;
                                                            ?>
                                                        </td>
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($supplier['created_at'])) ?></td>
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($supplier['updated_at'])) ?></td>
                                                        <td>
                                                            <a href="" class="editSupplierIcon" data-id="<?= $supplier['id'] ?>"><i class="fa-solid fa-pencil"></i> Edit</a>
                                                            <a href="" class="deleteSupplierIcon" data-name="<?= $supplier['supplier_name'] ?>" data-id="<?= $supplier['id'] ?>"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <p class="userCount"><?= count($suppliers) ?> Suppliers</p>
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

            $target_table = 'products';
            $products = include('database/show-function.php');

            $product_arr = [];

            foreach($products as $product) {
                $product_arr[$product['id']] = $product['product_name'];
            }

            $product_arr = json_encode($product_arr);
        ?>
    
    <script>
        var products = <?= $product_arr ?>;

        function script() {
            var t = this;

            // Initialising events
            this.initialize = function() {
                this.registerEvents();
            },

            // Looking for a click function 
            this.registerEvents = function() {
                $(document).on('submit', '#editSupplierInfoForm', function(e) {
                    e.preventDefault();
                    script.saveSupplierUpdatedData(this);
                });

                document.addEventListener('click', function(e) {
                    targetElement = e.target;

                    if(targetElement.classList.contains('deleteSupplierIcon')) {
                        e.preventDefault();

                        sId = targetElement.dataset.id;
                        supplierName = targetElement.dataset.name;

                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Delete Supplier',
                            message: 'Are you sure you want to delete this supplier: <strong>' + supplierName + '</strong>?',
                            callback: function(isDelete) {
                                if(isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: { id: sId, table: 'suppliers' },
                                        url: 'database/delete-function.php',
                                        dataType: 'json',
                                        success: function(data) {
                                            const message = data.success ? 
                                                supplierName + ' has been deleted from the database!' : 'Error processing request!';

                                            BootstrapDialog.alert({
                                                type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                                message: message,
                                                callback: function() {
                                                    if (data.success) location.reload();
                                                }
                                            });
                                        }
                                    });
                                } else { alert('Not deleting'); }
                            }
                        });
                    }

                    if(targetElement.classList.contains('editSupplierIcon')) {
                        e.preventDefault();

                        id = targetElement.dataset.id;
                        t.toggleEditDialog(id);
                    }
                });
            },

            this.saveSupplierUpdatedData = function(form) {
                $.ajax({
                    method: 'POST',
                    data: {
                        supplier_name: document.getElementById('supplier_name').value,
                        supplier_location: document.getElementById('supplier_location').value,
                        email: document.getElementById('email').value,
                        products: $('#selectionBox').val(),
                        id: document.getElementById('id').value,

                    },
                    url: 'database/update-suppliers.php',
                    dataType: 'json',
                    success: function(data) {
                        BootstrapDialog.alert({
                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                            message: data.message,
                            callback: function() { 
                                if(data.success) location.reload(); 
                            }
                        });
                    }
                });
            }

            // Edit Products Dialog Toggle Function
            this.toggleEditDialog = function(id) {
                $.get('database/get-supplier-info.php', {id: id}, function(data) {
                    let currentProducts = data['products_list'];
                    let productOptions = '';

                    for(const [productId, productName] of Object.entries(products)) {
                        selected = currentProducts.indexOf(productId) > -1 ? 'selected' : '';
                        productOptions += "<option "+ selected +" value='"+ productId +"'>"+ productName +"</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'Are you sure you want to update this supplier information: <strong>' + data.supplier_name + '</strong>?',
                        message: '<form id="editSupplierInfoForm" action="#" method="POST" enctype="multipart/form-data">\
                                        <div class="addUserFormInputBox">\
                                            <label for="supplier_name">Supplier Name</label>\
                                            <input type="text" class="addUserInput" id="supplier_name" value="'+ data.supplier_name +'" name="supplier_name" />\
                                        </div>\
                                        <div class="addUserFormInputBox">\
                                            <label for="supplier_location">Supplier Location</label>\
                                            <input type="text" class="addUserInput" id="supplier_location" value="'+ data.supplier_location +'" name="supplier_location" />\
                                        </div>\
                                        <div class="addUserFormInputBox">\
                                            <label for="email">Email</label>\
                                            <input type="email" class="addUserInput" id="email" value="'+ data.email +'" name="email" />\
                                        </div>\
                                        <div class="addUserFormInputBox">\
                                            <label for="choiceBox">Supplied Products</label>\
                                            <select name="products[]" id="selectionBox" multiple="">\
                                                '+ productOptions +'\
                                            </select>\
                                        </div>\
                                        <input type="hidden" name="id" id="id" value="'+ data.id +'" />\
                                        <input type="submit" value="submit" id="editSupplierSubmitBtn" class="hidden"/>\
                                    </form>',
                        callback: function(isUpdate) {
                            if(isUpdate) {
                                document.getElementById('editSupplierSubmitBtn').click();
                            } else alert('Not updating');
                        }
                    });
                }, 'json');
            }
        }
        var script = new script;
        script.initialize();
    </script>  
    </body>
</html>