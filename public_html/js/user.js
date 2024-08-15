document.addEventListener("DOMContentLoaded",()=>{
    let signUp= document.getElementById("signUp");
    if(signUp !== null){
        signUp.addEventListener("submit",(evt)=>{
            evt.preventDefault();

            document.querySelector("input[type=submit]").blur();

            let required= signUp.querySelectorAll("input[required]:not([type=checkbox])");
            let requiredCheckbox= signUp.querySelectorAll("input[required][type=checkbox]");

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

            let formData= new FormData(signUp);

            if(validateEmail(formData.get("form[email]")) === null){
                console.log("email null");
                signUp.querySelector("#suEmail").classList.add("is-invalid");
            }

            if(formData.get("form[password]") !== formData.get("form[retry]")){
                signUp.querySelector("#suRetry").classList.add("is-invalid");
                signUp.querySelector("#suPass").classList.add("is-invalid");
            }

            let errorsCnt= signUp.querySelectorAll("input.is-invalid").length;

            fetch(signUp.getAttribute("action"),{
                method: "POST",
                body: formData,
            })
                .then(response => {return response.text();})
                .then(data => {
                    console.log(data);
                    //data= JSON.parse(data);
                });



        });
    }
});
const validateEmail = (email) => {
    return String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};