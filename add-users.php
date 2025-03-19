<?php
    // Starting the session
    session_start();

    if(!isset($_SESSION['user'])) header('location: index.php');
    $_SESSION['table'] = 'users';
    $user = $_SESSION['user'];
?>

<html>
    <head>
        <title>Dashboard - Morty's Pet Store Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script src="https://kit.fontawesome.com/65a31e3d12.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="dashBoardMainContainer">
            <?php include('prefabs/dashboard-sidebar.php') ?>
            <div class="dashBoardContentContainer" id="dashBoardContentContainer">
                <?php include('prefabs/dashboard-top-nav-bar.php') ?>
                <div class="dashBoardContent">
                    <div class="contentMainBody">
                        <div class="row">
                            <div class="column addUserFormColumn">
                                <h1 class="columnHeader"`>Add User Information</h1> 
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
                            <div class=" column userListColumn">
                                <p>Hi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="js/script.js"></script>    
    </body>
</html>