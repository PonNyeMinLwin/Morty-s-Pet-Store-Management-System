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