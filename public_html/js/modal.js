document.addEventListener("DOMContentLoaded",()=>{
    let modal       = document.getElementById("modal");

    if (modal === null) return false;

    let modalContent    = modal.querySelector("#modalContent");

    document.querySelectorAll(".show-modal").forEach(el=>{
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


    let rem = parseFloat(getComputedStyle(document.documentElement).fontSize);

    let offset= 100*(1 - modalContent.offsetHeight/window.screen.height)/2;

    let offsetPX = offset*window.screen.height/100;

    let top         = 6.5*rem;
    let height      = window.screen.height - 17*rem;


    modalContent.style.top              = offset    + "vh";

    if(offsetPX < top){
        modalContent.style.top          = top       + "px";
        modalContent.style.maxHeight    = height    + "px";
    }
}

function showModal(panel){
    let modal       = document.getElementById("modal");
    if (modal === null) return false;

    let modalContent    = modal.querySelector("#modalContent");
    if (modalContent === null) return false;

    if(panel === null || modalContent.querySelector(panel) === null)
        return false;

    if(modal.classList.contains("active"))
        showModalAction(modalContent,panel)
    else{
        hidePanels(modalContent);
        modalContent.querySelector(panel).classList.remove("d-none");
        setModalHeight(modalContent);
        modal.classList.add("active");
    }
}

function closeModal()
{
    document.getElementById("modal").classList.remove("active");
    return false;
}

function modalAction(el)
{
    let modalContent    = document.querySelector("#modal #modalContent");
    if(modalContent === null) return false;

    let panel = modalContent.querySelector("#message");
    let action  = el.getAttribute("data-action");

    fetch(action,{
        method:             "GET",
    })
        .then(response => {return response.text();})
        .then(data => {
            data= JSON.parse(data);
            if(data.code === 200){
                switch (data.action){
                    case "ShowMessage":

                        let time= 1250;

                        modalContent.classList.add("hide");

                        let timer1= setTimeout(()=>{
                            hidePanels(modalContent);
                            panel.innerHTML = data.message;
                            panel.classList.remove("d-none");
                            setModalHeight(modalContent);
                        },time/2);

                        let timer2= setTimeout(()=>{
                            modalContent.classList.remove("hide");
                        },time);

                    break;
                }
            }
        });

    return false;
}