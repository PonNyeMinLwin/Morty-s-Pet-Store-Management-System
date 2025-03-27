<?php
    // Starting the session
    session_start();
    if(!isset($_SESSION['user'])) header('location: index.php');

    $_SESSION['table'] = 'users';
    $_SESSION['redirect_to'] = 'add-users.php'; 

    $target_table = 'users';
    $usersList = include('database/show-function.php');
?>

<html>
    <head>
        <title>Add Users - Morty's Pet Store Management System</title>
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
                                <h1 class="columnHeader"><i class="fa-solid fa-user-plus"></i> Add User Information</h1> 
                                <div id="addUserFormContainer">
                                    <form action="database/add-function.php" method="POST" class="addUserForm">
                                        <div class="addUserFormInputBox">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="addUserInput" id="first_name" name="first_name" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="addUserInput" id="last_name" name="last_name" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="email">Email</label>
                                            <input type="email" class="addUserInput" id="email" name="email" />
                                        </div>
                                        <div class="addUserFormInputBox">
                                            <label for="password">Password</label>
                                            <input type="password" class="addUserInput" id="password" name="password" />
                                        </div>
                                        <button type="submit" class="addUserBtn"><i class="fa-solid fa-user-plus"></i> Add User</button>
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