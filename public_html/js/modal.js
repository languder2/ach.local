document.addEventListener("DOMContentLoaded",()=>{
    let modal = document.getElementById("modal");

    if (modal === null)
        return false;

    document.querySelectorAll(".show-modal").forEach(el=>{
        el.addEventListener("click",()=>{
            modal.classList.add("active");
        });
    });

    modal.addEventListener("click",(evt)=>{
        if(evt.target.id === "modal")
            modal.classList.remove("active");
    });

    document.addEventListener('keydown', function(evt) {
        if (evt.key === "Escape")
            modal.classList.toggle("active");

        if (evt.key === "Escape")
            console.clear();
    });
});
