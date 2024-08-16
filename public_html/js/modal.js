document.addEventListener("DOMContentLoaded",()=>{
    let modal       = document.getElementById("modal");

    if (modal === null) return false;

    let modalContent    = modal.querySelector("#modalContent");

    document.querySelectorAll(".show-modal, .test").forEach(el=>{
        el.addEventListener("click",(evt)=>{
            evt.preventDefault();

            let action = el.getAttribute("data-action");

            if(action === null || modalContent.querySelector(action) === null)
                return false;

            if(modal.classList.contains("active"))
                showModalAction(modalContent,action)
            else{
                hidePanels(modalContent);

                modalContent.querySelector(action).classList.remove("d-none");

                setModalHeight(modalContent);

                modal.classList.add("active");
            }
        });
    });

    modal.addEventListener("mousedown",(evt)=>{
        if(evt.target.id === "modal")
            modal.classList.remove("active");
    });

    document.addEventListener('keydown', function(evt) {
        if (evt.key === "Escape")
            modal.classList.toggle("active");

        if (evt.key === "Escape" || evt.key === "=")
            console.clear();

        if (evt.key === "0")
            setHeight(
                document.querySelector(".callout-wrapper"),
                document.querySelector(".callout-wrapper .callout")
            );
    });
});

function showModalAction(modalContent,action){
    if(modalContent.classList.contains("hide"))
        return false;

    let time= 1250;

    modalContent.classList.add("hide");

    let timer1= setTimeout(()=>{
        hidePanels(modalContent);
        modalContent.querySelector(action).classList.remove("d-none");
        setModalHeight(modalContent);
    },time/2);

    let timer2= setTimeout(()=>{
        modalContent.classList.remove("hide");
    },time);

}

function hidePanels(modalContent){
    modalContent.querySelectorAll(".panel:not(.d-none)").forEach(el=>{
        el.classList.add("d-none");
    });
}

function setModalHeight(modalContent){

    let offset= 100*(1 - modalContent.offsetHeight/window.screen.height) / 2;

    if(offset > 20)
        offset*= 1;

    else
        if(offset <=0)
            offset = 0;

    modalContent.style.top = offset+"vh";
}