document.addEventListener("DOMContentLoaded", ()=>{
    let btnShowMenu= document.getElementById("show-menu");
    let menu= document.getElementById("menu");

    if(btnShowMenu === null || menu === null) return false;

    btnShowMenu.addEventListener("click", (e)=>{
        btnShowMenu.classList.toggle("active");

        if(btnShowMenu.classList.contains("active"))
            menu.style.height = menu.scrollHeight+parseFloat(getComputedStyle(document.documentElement).fontSize)+"px";
        else
            menu.style.height = "0";
    });


});