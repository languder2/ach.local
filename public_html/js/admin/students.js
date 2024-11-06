document.addEventListener("DOMContentLoaded", ()=>{
    let list = document.querySelectorAll("a.show-students");

    if(list.length === 0 ) return false;

    list.forEach(el => {
        el.addEventListener("click",(evt)=>{

            evt.preventDefault();

            el.closest("tr").classList.toggle("show-education-detail");
            document.querySelector("td[data-uid='"+el.getAttribute("data-uid")+"']").classList.toggle("d-none");
        });
    });
});