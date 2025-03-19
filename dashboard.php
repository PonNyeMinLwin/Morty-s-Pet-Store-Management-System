<?php
    // Starting the session
    session_start();

    if(!isset($_SESSION['user'])) header('location: index.php');
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
                    </div>
                </div>
            </div>
        </div>
        
        <script src="js/script.js"></script> 
    </body>
</html>