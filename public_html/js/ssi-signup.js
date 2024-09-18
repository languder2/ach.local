document.addEventListener("DOMContentLoaded",()=>{
    let ssiStep1        = document.getElementById("ssiStep1");
    if(!ssiStep1) return;

    ssiStep1.addEventListener("submit",(e)=>{
        let error           = false;

        let pass        = document.getElementById("suPass");
        let confirm     = document.getElementById("suConfirm");

        if(pass.value !== confirm.value){
            error = true;
            pass.classList.add("is-invalid");
            confirm.classList.add("is-invalid");
        }
        else{
            pass.classList.remove("is-invalid");
            confirm.classList.remove("is-invalid");
        }

        if(error)
            e.preventDefault()

        return true;
    });



});