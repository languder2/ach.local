document.addEventListener("DOMContentLoaded",()=> {
    let signUp= document.getElementById("signUp");
    if(signUp){
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

            fetch(signUp.getAttribute("action"),{
                method: "POST",
                body: formData,
            })
                .then(response => {return response.text();})
                .then(data => {
                    console.clear();

                    let inputs= signUp.querySelectorAll("input.is-invalid");
                    inputs.forEach(el=>{
                        el.classList.remove("is-invalid");
                    });

                    data= JSON.parse(data);

                    console.log(data);

                    if(data.errors && data.errors.length)
                        data.errors.forEach((name)=>{
                            let el= signUp.querySelector("[name='"+name+"']");
                            el.classList.add("is-invalid");
                            return false;
                        });

                    if(data.status && data.status === "error"){
                        switch (data.code){
                            case "emailOccupied":
                                signUp.querySelector("#suEmail").classList.add("is-invalid");

                                document.querySelector("#modal .callout-error").innerHTML= data.message;

                                setHeight(
                                    document.querySelector(".callout-wrapper"),
                                    "show"
                                );

                            break;
                            case "noValidate":

                                break;
                            default:
                                console.log(data.code);
                            break;
                        }

                        return false;
                    }

                    if(data.status === "success")
                        location.href = data.page;

                    if(data.status === "true"){
                        setHeight(
                            document.querySelector(".callout-wrapper"),
                            "hide"
                        );
                    }


                });
        });
    }

});
document.addEventListener("DOMContentLoaded",()=> {
    let signIn= document.getElementById("signIn");

    if(signIn){
        signIn.addEventListener("submit",e=>{

            e.preventDefault();

            let email   = document.getElementById("signInET");
            let pass    = document.getElementById("signInPass");

            email.classList.remove("is-invalid")

            let data= new FormData(signIn);

            fetch(signIn.getAttribute("action"),{
                method:             "POST",
                body:               data,
            })
                .then(response => {return response.text();})
                .then(data => {
                    data= JSON.parse(data);
                    if(data.status === "success")
                        location.href = data.page;

                    else if(data.status === "error"){
                        signIn.querySelector(".callout-wrapper .callout").textContent = data.message;
                        signIn.querySelector(".callout-wrapper").classList.remove("hide");
                    }

                });


            return false;
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    let rp= document.getElementById("RecoverPassword");

    if(rp) {
        rp.addEventListener("submit",(evt)=>{
            evt.preventDefault();

            let email   = rp.querySelector("#rpEmail");

            if(!validateEmail(email.value)){
                email.classList.add("is-invalid");
                return false;
            }
            else{

                let data= new FormData(rp);

                fetch(rp.getAttribute("action"),{
                    method:             "POST",
                    body:               data,
                })
                    .then(response => {return response.text();})
                    .then(data => {

                        data= JSON.parse(data);

                        if(data.status === "success"){
                            let modalContent       = document.querySelector("#modal #modalContent");

                            modalContent.querySelector("#message").innerHTML = data.message;

                            showModalAction(modalContent,"#message");
                        }
                        else if(data.status === "error"){
                            rp.querySelector(".callout-wrapper .callout").textContent = data.message;
                            rp.querySelector(".callout-wrapper").classList.remove("hide");
                        }
                        else if(data.status === "log")
                            console.log(data);

                    });
            }

        })

    }
});

document.addEventListener("DOMContentLoaded",() =>  {
    let formCP= document.getElementById("ChangePassword");

    if(!formCP) return false;

    formCP.addEventListener("submit", (evt) => {
        let pass    = formCP.querySelector("[name='form[password]']");
        let retry   = formCP.querySelector("[name='form[retry]']");

        if(pass.value !== retry.value){
            evt.preventDefault();
            pass.classList.add("is-invalid");
            retry.classList.add("is-invalid");
        }

    });
});