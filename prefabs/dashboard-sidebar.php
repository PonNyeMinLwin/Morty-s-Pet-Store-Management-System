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
                    <a href="javascript:void(0);" class="dropDownFunction">
                        <i class="fa-solid fa-paw dropDownFunction"></i>
                        <span class="sideBarText dropDownFunction">Product Management</span>
                        <i class="fa-solid fa-angle-left leftIconArrow dropDownFunction"></i>
                    </a>
                    <ul class="dropDownMenus">
                        <li><a href="#" class="functions"><i class="fa-regular fa-circle"></i>View Products</a></li>
                        <li><a href="#" class="functions"><i class="fa-regular fa-circle"></i>Add Products</a></li>
                    </ul>
                </li>
                <li class="sideBarMainList">
                    <a href="javascript:void(0);" class="dropDownFunction">
                        <i class="fa-solid fa-truck-fast dropDownFunction"></i>
                        <span class="sideBarText dropDownFunction">Supplier Management</span>
                        <i class="fa-solid fa-angle-left leftIconArrow dropDownFunction"></i>
                    </a>
                    <ul class="dropDownMenus">
                        <li><a href="#" class="functions"><i class="fa-regular fa-circle"></i>View Suppliers</a></li>
                        <li><a href="#" class="functions"><i class="fa-regular fa-circle"></i>Add Suppliers</a></li>
                    </ul>
                </li>
                <li class="sideBarMainList">
                    <a href="javascript:void(0);" class="dropDownFunction">
                        <i class="fa-solid fa-users dropDownFunction"></i>
                        <span class="sideBarText dropDownFunction">User Management</span>
                        <i class="fa-solid fa-angle-left leftIconArrow dropDownFunction"></i>
                    </a>
                    <ul class="dropDownMenus">
                        <li><a href="#" class="functions"><i class="fa-regular fa-circle"></i>View Users</a></li>
                        <li><a href="#" class="functions"><i class="fa-regular fa-circle"></i>Add Users</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</html>