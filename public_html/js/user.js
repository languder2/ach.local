document.addEventListener("DOMContentLoaded",()=>{
    let signUp= document.getElementById("signUp");
    if(signUp !== null){
        signUp.addEventListener("submit",(evt)=>{
            evt.preventDefault();
            let formData= new FormData(signUp);
            let required= signUp.querySelectorAll("input[required]:not([value=''])");

            if(formData.get("form[password]") != formData.get("form[retry]")){
                console.log("no retry");
            }


        });
    }
});

