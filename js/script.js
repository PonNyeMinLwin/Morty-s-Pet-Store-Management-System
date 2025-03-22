var sideBarActive = true;

// Side Bar Toggle Function
toggleSideBarButton.addEventListener('click', (event) => {
    event.preventDefault();

    if(sideBarActive) {
        dashBoardToggleSideBar.style.width = '10%';
        dashBoardToggleSideBar.style.transition = '0.3s all';
        dashBoardContentContainer.style.width = '100%';
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

// Sub-Menus Drop Down Toggle Function
document.addEventListener('click', function(e) {
    let target = e.target;

    if(target.classList.contains('dropDownFunction')) {
        let dropDownDisplay = target.closest('li').querySelector('.dropDownMenus');
        let dropDownArrow = target.closest('li').querySelector('.leftIconArrow');

        // Checking if there is a drop down menu and changing icon
        if(dropDownDisplay != null) {
            if(dropDownDisplay.style.display === 'block') { 
                dropDownDisplay.style.display = 'none'; 
                dropDownArrow.classList.remove('fa-angle-down');
                dropDownArrow.classList.add('fa-angle-left');
                
            } else { 
                dropDownDisplay.style.display = 'block'; 
                dropDownArrow.classList.remove('fa-angle-left');
                dropDownArrow.classList.add('fa-angle-down');
            }
        }
    }
});