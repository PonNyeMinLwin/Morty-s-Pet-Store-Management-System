<html>
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
</html>