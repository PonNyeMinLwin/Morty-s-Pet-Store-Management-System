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

// Click Event Listener
document.addEventListener('click', function(e) {
    let target = e.target;
    
    // Finding a dropDownFunction tag and inititialising variables
    if(target.classList.contains('dropDownFunction')) {
        let dropDownDisplay = target.closest('li').querySelector('.dropDownMenus');
        let dropDownArrow = target.closest('li').querySelector('.leftIconArrow');

        // Closing all other drop down menus when one is clicked
        document.querySelectorAll('.dropDownMenus').forEach((label) => {
            if(label != dropDownDisplay) { label.style.display = 'none'; }
        });

        // Toggling drop down menus and changing arrow icons
        toggleDropDownMenu(dropDownDisplay, dropDownArrow);
    }
});

// Drop Down Toggle Function
function toggleDropDownMenu(dropDownDisplay, dropDownArrow) {
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

// Active Page Directory Function
let path = window.location.pathname.split('/');
let currentPage = path[path.length - 1];

let currentLink = document.querySelector('a[href="./'+ currentPage +'"]');
currentLink.classList.add('dropDownMenusActive');

let currentSubMenu = currentLink.closest('li.sideBarMainList');
currentSubMenu.style.background = '#f685a1';

let subMenu = currentLink.closest('.dropDownMenus');
let dropDownArrow = currentSubMenu.querySelector('i.leftIconArrow');

toggleDropDownMenu(subMenu, dropDownArrow);