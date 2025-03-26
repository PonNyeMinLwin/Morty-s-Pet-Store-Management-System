<?php
    // Starting the session
    session_start();
    if(!isset($_SESSION['user'])) header('location: index.php');

    $_SESSION['table'] = 'suppliers';
    $_SESSION['redirect_to'] = 'add-suppliers.php'; 
    $user = $_SESSION['user']; 
?>

<html>
    <head>
        <title>Add Suppliers - Morty's Pet Store Management System</title>
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
                                <h1 class="columnHeader"><i class="fa-solid fa-plus"></i> Create Suppliers</h1> 
                                <div id="addUserFormContainer">
                                    <form action="database/add-function.php" method="POST" class="addUserForm" enctype="multipart/form-data">
                                        <div class="addUserFormInputBox">
                                            <label for="supplier_name">Supplier Name</label>
                                            <input type="text" class="addUserInput" placeholder="Enter supplier name..." id="supplier_name" name="supplier_name" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="supplier_location">Supplier Location</label>
                                            <input type="text" class="addUserInput" placeholder="Enter the location of the supplier's main warehouse..." id="supplier_location" name="supplier_location" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="email">Email</label>
                                            <input type="email" class="addUserInput" placeholder="Enter main supplier email..." id="email" name="email" />
                                        </div>
                                        <button type="submit" class="addUserBtn"><i class="fa-solid fa-user-plus"></i> Add Supplier</button>
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