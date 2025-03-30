<?php
    // Starting the session
    session_start();

    if(!isset($_SESSION['user'])) header('location: index.php');
?>

<html>
    <head>
        <title>Reports - Morty's Pet Store Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script src="https://kit.fontawesome.com/65a31e3d12.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="dashBoardMainContainer">
            <?php include('prefabs/dashboard-sidebar.php') ?>
            <div class="dashBoardContentContainer" id="dashBoardContentContainer">
                <?php include('prefabs/dashboard-top-nav-bar.php') ?>
                <div id="reportsContentContainer">
                    <div class="reportsBoxContainer">
                        <div class="reportsBox">
                            <p><i class="fa-solid fa-file-export"></i> Export Product Analysis</p>
                            <div class="">
                                <a href="" class="exportBtns"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                                <a href="" class="exportBtns"><i class="fa-solid fa-file-excel"></i> Excel</a>
                            </div>
                        </div>
                        <div class="reportsBox">
                            <p><i class="fa-solid fa-file-export"></i> Export Order Analysis</p>
                            <div class="">
                                <a href="" class="exportBtns"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                                <a href="" class="exportBtns"><i class="fa-solid fa-file-excel"></i> Excel</a>
                            </div>
                        </div>
                    </div>
                    <div class="reportsBoxContainer">
                        <div class="reportsBox">
                            <p><i class="fa-solid fa-file-export"></i> Export Supplier Analysis</p>
                            <div class="">
                                <a href="" class="exportBtns"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                                <a href="" class="exportBtns"><i class="fa-solid fa-file-excel"></i> Excel</a>
                            </div>
                        </div>
                        <div class="reportsBox">
                            <p><i class="fa-solid fa-file-export"></i> Export Inventory Analysis</p>
                            <div class="">
                                <a href="" class="exportBtns"><i class="fa-solid fa-file-pdf"></i> PDF</a>
                                <a href="" class="exportBtns"><i class="fa-solid fa-file-excel"></i> Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="js/script.js"></script>
    </body>
</html>