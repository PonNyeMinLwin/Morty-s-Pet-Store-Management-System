<?php
    // Starting the session
    session_start();

    if(!isset($_SESSION['user'])) header('location: index.php');
    $_SESSION['table'] = 'users';
    $user = $_SESSION['user'];

    $usersList = include('database/show-database-function.php');
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
                                <h1 class="columnHeader"><i class="fa-solid fa-plus"></i> Add User Information</h1> 
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
                            <div class="column userListColumn">
                                <h1 class="columnHeader"><i class="fa-solid fa-list"></i> List of Users</h1>
                                <div class="userListContainer">
                                    <div class="usersList">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Created At</th>
                                                    <th>Last Updated At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($usersList as $index => $user) { ?>
                                                    <tr>
                                                        <td><?= $index + 1 ?></td>
                                                        <td><?= $user['first_name'] ?></td>
                                                        <td><?= $user['last_name'] ?></td>
                                                        <td><?= $user['email'] ?></td>
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                                        <td><?= date('F d, Y @ h:i:s A', strtotime($user['last_updated_at'])) ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <p class="userCount"><?= count($usersList) ?> Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="js/script.js"></script>    
    </body>
</html>