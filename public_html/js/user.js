document.addEventListener("DOMContentLoaded",()=>{
    let signUp= document.getElementById("signUp");
    if(signUp !== null){
        signUp.addEventListener("submit",(evt)=>{
            evt.preventDefault();

            let required= signUp.querySelectorAll("input[required]");

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
                return false;
            }

            if(formData.get("form[password]") !== formData.get("form[retry]")){
                console.log("pass != retry");
            }
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