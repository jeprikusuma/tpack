 document.addEventListener("DOMContentLoaded", function () {
    const menuList = document.getElementById("sidebar");
    const menuListClone = document.getElementById("sidebarMobile");
    menuListClone.innerHTML = menuList.innerHTML;
});