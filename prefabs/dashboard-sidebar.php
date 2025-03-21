<html>
    <div class="dashBoardToggleSideBar" id="dashBoardToggleSideBar">
        <h3 class="sideBarTitle" id="sideBarTitle">Morty's Pet Store Management System</h3>
        <div class="dashBoardUserSection">
            <img src="assets/profiles/omni-man.jpg" alt="User Image" />
            <span><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
        </div>
        <div class="dashBoardSideBar">
            <ul class="dashBoardSideBarMenus">
                <li class="sideBarMainList">
                    <a href="./dashboard.php"><i class="fa-solid fa-gauge-high"></i><span class="sideBarText"> Dashboard</span></a>
                </li>
                <li class="sideBarMainList">
                    <a href=""><i class="fa-solid fa-paw"></i><span class="sideBarText">Product Management</span></a>
                </li>
                <li class="sideBarMainList">
                    <a href=""><i class="fa-solid fa-dolly"></i><span class="sideBarText">Supplier Management</span></a>
                </li>
                <li class="sideBarMainList">
                    <a href="javascript:void(0)" class="dropDownMenuLink">
                        <i class="fa-solid fa-users"></i><span class="sideBarText">User Management</span><i class="fa-solid fa-angle-left leftIconArrow"></i>
                    </a>
                    <ul class="dropDownMenus">
                        <li><a href="#" class="dropDownMenu"><i class="fa-regular fa-circle"></i> View User</a></li>
                        <li><a href="#" class="dropDownMenu"><i class="fa-regular fa-circle"></i> Add User</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</html>