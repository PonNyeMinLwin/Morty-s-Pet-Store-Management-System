<?php
    // Starting the session
    session_start();
    if(!isset($_SESSION['user'])) header('location: index.php');

    $_SESSION['table'] = 'products';
    $_SESSION['redirect_to'] = 'add-products.php'; 
    $user = $_SESSION['user'];
?>

<html>
    <head>
        <title>Add Products - Morty's Pet Store Management System</title>
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
                                <h1 class="columnHeader"><i class="fa-solid fa-plus"></i> Create Products</h1> 
                                <div id="addUserFormContainer">
                                    <form action="database/add-function.php" method="POST" class="addUserForm" enctype="multipart/form-data">
                                        <div class="addUserFormInputBox">
                                            <label for="product_name">Product Name</label>
                                            <input type="text" class="addUserInput" placeholder="Enter product name..." id="product_name" name="product_name" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="product_type">Product Type</label>
                                            <input type="text" class="addUserInput" placeholder="Eg. food, cages, toys" id="product_type" name="product_type" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="info">Description</label>
                                            <textarea class="addUserInput productInfoBoxInput" placeholder="Enter a brief description of the product..." id="info" name="info"></textarea>
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="product_name">Image</label>
                                            <input type="file" name="img" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="price">Price</label>
                                            <input type="text" class="addUserInput" id="price" name="price" />
                                        </div>
                                        <button type="submit" class="addUserBtn"><i class="fa-solid fa-user-plus"></i> Add Product</button>
                                    </form>
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
        </div>
        <?php include('prefabs/script-footer-links.php'); ?>
    </body>
</html>