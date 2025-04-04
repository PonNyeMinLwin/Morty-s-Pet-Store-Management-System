<?php
    $user = $_SESSION['user'];
?>

<html>
    <div class="dashBoardToggleSideBar" id="dashBoardToggleSideBar">
        <h3 class="sideBarTitle" id="sideBarTitle">Morty's Pet Store Management System</h3>
        <div class="dashBoardUserSection">
            <img src="assets/profiles/dog-pfp-1.jpg" alt="User Image" />
            <span><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
        </div>
        <div class="dashBoardSideBar">
            <ul class="dashBoardSideBarMenus">
                <li class="sideBarMainList">
                    <a href="./dashboard.php"><i class="fa-solid fa-gauge-high"></i><span class="sideBarText"> Dashboard</span></a>
                </li>
                <li class="sideBarMainList">
                    <a href="./reports.php"><i class="fa-solid fa-file-lines"></i><span class="sideBarText"> Business Reports</span></a>
                </li>
                <li class="sideBarMainList">
                    <a href="javascript:void(0);" class="dropDownFunction">
                        <i class="fa-solid fa-paw dropDownFunction"></i>
                        <span class="sideBarText dropDownFunction">Products</span>
                        <i class="fa-solid fa-angle-left leftIconArrow dropDownFunction"></i>
                    </a>
                    <ul class="dropDownMenus">
                        <li><a href="./view-products.php" class="functions"><i class="fa-regular fa-circle"></i>View Products</a></li>
                        <li><a href="./add-products.php" class="functions"><i class="fa-regular fa-circle"></i>Add Products</a></li>
                    </ul>
                </li>
                <li class="sideBarMainList">
                    <a href="javascript:void(0);" class="dropDownFunction">
                        <i class="fa-solid fa-receipt"></i>
                        <span class="sideBarText dropDownFunction"> Stock Orders</span>
                        <i class="fa-solid fa-angle-left leftIconArrow dropDownFunction"></i>
                    </a>
                    <ul class="dropDownMenus">
                        <li><a href="./view-stock-order.php" class="functions"><i class="fa-regular fa-circle"></i>View Stock Orders</a></li>
                        <li><a href="./add-stock-order.php" class="functions"><i class="fa-regular fa-circle"></i>Add New Stock Order</a></li>
                    </ul>
                </li>
                <li class="sideBarMainList">
                    <a href="javascript:void(0);" class="dropDownFunction">
                        <i class="fa-solid fa-truck-fast dropDownFunction"></i>
                        <span class="sideBarText dropDownFunction">Suppliers</span>
                        <i class="fa-solid fa-angle-left leftIconArrow dropDownFunction"></i>
                    </a>
                    <ul class="dropDownMenus">
                        <li><a href="./view-suppliers.php" class="functions"><i class="fa-regular fa-circle"></i>View Suppliers</a></li>
                        <li><a href="./add-suppliers.php" class="functions"><i class="fa-regular fa-circle"></i>Add Suppliers</a></li>
                    </ul>
                </li>
                <li class="sideBarMainList">
                    <a href="javascript:void(0);" class="dropDownFunction">
                        <i class="fa-solid fa-users dropDownFunction"></i>
                        <span class="sideBarText dropDownFunction">Users</span>
                        <i class="fa-solid fa-angle-left leftIconArrow dropDownFunction"></i>
                    </a>
                    <ul class="dropDownMenus">
                        <li><a href="./view-users.php" class="functions"><i class="fa-regular fa-circle"></i>View Users</a></li>
                        <li><a href="./add-users.php" class="functions"><i class="fa-regular fa-circle"></i>Add Users</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</html>