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
                                                            <a href="" class="editProductIcon" data-id="<?= $supplier['id'] ?>"><i class="fa-solid fa-pencil"></i> Edit</a>
                                                            <a href="" class="deleteProductIcon" data-name="<?= $supplier['supplier_name'] ?>" data-id="<?= $supplier['id'] ?>"><i class="fa-solid fa-trash"></i> Delete</a>
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

            $target_table = 'suppliers';
            $suppliers = include('database/show-function.php');

            $supplier_arr = [];

            foreach($suppliers as $supplier) {
                $supplier_arr[$supplier['id']] = $supplier['supplier_name'];
            }

            $supplier_arr = json_encode($supplier_arr);
        ?>
    
    <script>
        var suppliers = <?= $supplier_arr ?>;

        function script() {
            var t = this;

            // Initialising events
            this.initialize = function() {
                this.registerEvents();
            },

            // Looking for a click function 
            this.registerEvents = function() {
                $(document).on('submit', '#editProductInfoForm', function(e) {
                    e.preventDefault();
                    script.saveProductUpdatedData(this);
                });

                document.addEventListener('click', function(e) {
                    targetElement = e.target;

                    if(targetElement.classList.contains('deleteProductIcon')) {
                        e.preventDefault();

                        id = targetElement.dataset.id;
                        name = targetElement.dataset.name;

                        BootstrapDialog.confirm({
                            type: BootstrapDialog.TYPE_DANGER,
                            title: 'Delete Product',
                            message: 'Are you sure you want to delete this product: <strong>' + name + '</strong>?',
                            callback: function(isDelete) {
                                if(isDelete) {
                                    $.ajax({
                                        method: 'POST',
                                        data: { id: id, table: 'products' },
                                        url: 'database/delete-function.php',
                                        dataType: 'json',
                                        success: function(data) {
                                            const message = data.success
                                                ? name + ' has been deleted from the database!' : 'Error processing request!';

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

                    if(targetElement.classList.contains('editProductIcon')) {
                        e.preventDefault();

                        id = targetElement.dataset.id;
                        
                        t.toggleEditDialog(id);
                    }
                });
            },

            this.saveProductUpdatedData = function(form) {
                $.ajax({
                    method: 'POST',
                    data: new FormData(form),
                    url: 'database/update-products.php',
                    processData: false,
                    contentType: false,
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
                $.get('database/get-product-info.php', {id: id}, function(data) {
                    let current_suppliers = data['suppliers_list'];
                    let supplierOptions = '';

                    for(const [supplierId, supplierName] of Object.entries(suppliers)) {
                        selected = current_suppliers.indexOf(supplierId) > -1 ? 'selected' : '';
                        supplierOptions += "<option "+ selected +" value='"+ supplierId +"'>"+ supplierName +"</option>";
                    }

                    BootstrapDialog.confirm({
                        title: 'Are you sure you want to update this product entry: <strong>' + data.product_name + '</strong>?',
                        message: '<form id="editProductInfoForm" action="#" method="POST" enctype="multipart/form-data">\
                                        <div class="addUserFormInputBox">\
                                            <label for="product_name">Product Name</label>\
                                            <input type="text" class="addUserInput" id="product_name" value="'+ data.product_name +'" name="product_name" />\
                                        </div>\
                                        <div class="addUserFormInputBox">\
                                            <label for="product_type">Product Type</label>\
                                            <input type="text" class="addUserInput" id="product_type" value="'+ data.product_type +'" name="product_type" />\
                                        </div>\
                                        <div class="addUserFormInputBox">\
                                            <label for="info">Description</label>\
                                            <textarea class="addUserInput productInfoBoxInput" id="info" name="info"> '+ data.info +' </textarea>\
                                        </div>\
                                        <div class="addUserFormInputBox">\
                                            <label for="product_name">Image</label>\
                                            <input type="file" name="img" />\
                                        </div>\
                                        <div class="addUserFormInputBox">\
                                            <label for="price">Price</label>\
                                            <input type="text" class="addUserInput" id="price" value="'+ data.price +'" name="price" />\
                                        </div>\
                                        <div class="addUserFormInputBox">\
                                            <label for="choiceBox">Suppliers</label>\
                                            <select name="suppliers[]" id="suppliersSelectionBox" multiple="">\
                                                '+ supplierOptions +'\
                                            </select>\
                                        </div>\
                                        <input type="hidden" name="id" value="'+ data.id +'" />\
                                        <input type="hidden" name="current_img" value="' + data.img + '" />\
                                        <input type="submit" value="submit" id="editProductSubmitBtn" class="hidden"/>\
                                    </form>',
                        callback: function(isUpdate) {
                            if(isUpdate) {
                                document.getElementById('editProductSubmitBtn').click();
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