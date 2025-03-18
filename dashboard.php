<?php
    // Starting the session
    session_start();

    if(!isset($_SESSION['user'])) header('location: index.php');
    $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard - Morty's Pet Store Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script src="https://kit.fontawesome.com/65a31e3d12.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="dashBoardMainContainer">
            <div class="dashBoardToggleSideBar" id="dashBoardToggleSideBar">
                <h3 class="sideBarTitle" id="sideBarTitle">Morty's Pet Store Management System</h3>
                <div class="dashBoardUserSection">
                    <img src="assets/profiles/omni-man.jpg" alt="User Image" />
                    <span><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
                </div>
                <div class="dashBoardSideBar">
                    <ul class="dashBoardSideBarMenus">
                        <li class="sideBarList">
                            <a href=""><i class="fa-solid fa-gauge-high"></i><span class="sideBarText"> Dashboard</span></a>
                        </li>
                        <li>
                            <a href=""><i class="fa-solid fa-chart-line"></i><span class="sideBarText"> Analytics</span></a>
                        </li>
                        <li>
                            <a href=""><i class="fa-solid fa-bell"></i><span class="sideBarText"> Quick Alerts</span></a>
                        </li>
                        <li>
                            <a href=""><i class="fa-solid fa-cash-register"></i><span class="sideBarText"> Sales & Stock Report</span></a>
                        </li>
                        <li>
                            <a href=""><i class="fa-solid fa-gear"></i><span class="sideBarText"> Settings</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="dashBoardContentContainer" id="dashBoardContentContainer">
                <div class="contentTopNavBar">
                    <a href="" id="toggleSideBarButton"><i class="fa-solid fa-bars"></i></a>
                    <a href="database/logout_page.php" id="logOutButton"><i class="fa-solid fa-power-off"></i> Log Out</a>
                </div>
                <div class="dashBoardContent">
                    <div class="contentMainBody">

                    </div>
                </div>
            </div>
        </div>
    <script>
        var sideBarActive = true;

        toggleSideBarButton.addEventListener('click', (event) => {
            event.preventDefault();

            if(sideBarActive) {
                dashBoardToggleSideBar.style.width = '10%';
                dashBoardToggleSideBar.style.transition = '0.3s all';
                dashBoardContentContainer.style.width = '90%';
                sideBarTitle.style.fontSize = '20px';

                sideBarText = document.getElementsByClassName('sideBarText');
                for(var i = 0; i < sideBarText.length; i++) {
                    sideBarText[i].style.display = 'none';
                }
                document.getElementsByClassName('dashBoardSideBarMenus')[0].style.textAlign = 'center';
                sideBarActive = false;
            } else {
                dashBoardToggleSideBar.style.width = '20%';
                dashBoardContentContainer.style.width = '80%';
                sideBarTitle.style.fontSize = '25px';

                sideBarText = document.getElementsByClassName('sideBarText');
                for(var i = 0; i < sideBarText.length; i++) {
                    sideBarText[i].style.display = 'inline-block';
                    sideBarText[i].style.padding = '0px 8px';
                }
                document.getElementsByClassName('dashBoardSideBarMenus')[0].style.textAlign = 'left';
                sideBarActive = true;
            }
        });
    </script>    
    </body>
</html>