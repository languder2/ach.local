document.addEventListener("DOMContentLoaded",()=>{
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    let labels= document.querySelectorAll(".s-input-box label");
    if(labels.length)
        labels.forEach(el=>
           el.addEventListener("click",(e)=>
               e.target.parentElement.querySelector("input").focus()
           )
        );
})

const validateEmail = (email) => {
    return email
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        )?true:false;
};

function setHeight(wrapper,type){
    if(type === "show")
        wrapper.style.height= wrapper.scrollHeight+"px";
    else
        wrapper.style.height= "0";

    wrapper.parentElement.scrollIntoView({behavior: "smooth"});
}

