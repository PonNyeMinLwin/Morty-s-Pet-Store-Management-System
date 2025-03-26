<?php
    // Starting the session
    session_start();
    if(!isset($_SESSION['user'])) header('location: index.php');

    $_SESSION['table'] = 'products';
    $products = include('database/show-function.php');
?>

<html>
    <head>
        <title>View Products - Morty's Pet Store Management System</title>
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
                                <h1 class="columnHeader"><i class="fa-solid fa-list"></i> List of Products</h1>
                                <div class="userListContainer">
                                    <div class="usersList">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Product</th>
                                                    <th>Type</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($products as $index => $product) { ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td class="email"><img class="productImgs" src="inputs/product-images/<?= $product['img'] ?>" alt="" /></td>
                                                        <td class="firstName"><?= $product['product_name'] ?></td>
                                                        <td class="lastName"><?= $product['product_type'] ?></td>
                                                        <td class="email"><?= $product['info'] ?></td>
                                                        <td class="email"><?= $product['price'] ?></td>
                                                        <td>
                                                            <?php
                                                                $id = $product['created_by'];
                                                                $stmt = $conn->prepare("SELECT * FROM users WHERE id=$id");
                                                                $stmt->execute();
                                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                                
                                                                $product_creator = $row['first_name'] . ' ' . $row['last_name'];
                                                                echo $product_creator;
                                                            ?>
                                                        </td>
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($product['created_at'])) ?></td>
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($product['updated_at'])) ?></td>
                                                        <td>
                                                            <a href="" class="editProductIcon" data-id="<?= $product['id'] ?>"><i class="fa-solid fa-pencil"></i> Edit</a>
                                                            <a href="" class="deleteProductIcon" data-name="<?= $product['product_name'] ?>" data-id="<?= $product['id'] ?>"><i class="fa-solid fa-trash"></i> Delete</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <p class="userCount"><?= count($products) ?> Products</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('prefabs/script-footer-links.php') ?>
    
    <script>
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