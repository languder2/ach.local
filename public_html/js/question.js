document.addEventListener("DOMContentLoaded",()=> {
    let form= document.getElementById("askQuestion");

    if(form === null)   return false;

    form.addEventListener("submit",(evt)=>{
        evt.preventDefault();

        document.querySelector("input[type=submit]").blur();

        let required= form.querySelectorAll("input[required]:not([type=checkbox])");
        let requiredCheckbox= form.querySelectorAll("input[required][type=checkbox]");

        requiredCheckbox.forEach(el=>{
            if(el.checked)
                el.classList.remove("is-invalid");
            else
                el.classList.add("is-invalid");
        });

        required.forEach(el=>{
            if(el.value === '')
                el.classList.add("is-invalid");
            else
                el.classList.remove("is-invalid");
        });

        let formData= new FormData(form);

        if(validateEmail(formData.get("form[email]")) === null){
            console.log("email null");
            form.querySelector("#suEmail").classList.add("is-invalid");
        }

        if(formData.get("form[password]") !== formData.get("form[retry]")){
            form.querySelector("#suRetry").classList.add("is-invalid");
            form.querySelector("#suPass").classList.add("is-invalid");
        }

        fetch(form.getAttribute("action"),{
            method: "POST",
            body: formData,
        })
            .then(response => {return response.text();})
            .then(data => {
                console.clear();

                let inputs= form.querySelectorAll("input.is-invalid");
                inputs.forEach(el=>{
                    el.classList.remove("is-invalid");
                });

                data= JSON.parse(data);

                if(data.status === "send"){
                    let modalContent       = document.querySelector("#modal #modalContent");

                    modalContent.querySelector("#message").innerHTML = data.message;

                    showModalAction(modalContent,"#message");
                    console.log(data);

                }
                else
                    console.log(data);
            });
    });

});