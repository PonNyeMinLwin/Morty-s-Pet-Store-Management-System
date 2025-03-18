<html>
    <head>
        <title>Dashboard - Morty's Pet Store Management System</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script src="https://kit.fontawesome.com/65a31e3d12.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="dashBoardMainContainer">
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