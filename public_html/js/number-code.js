document.addEventListener("DOMContentLoaded",()=>{

    const inputs = document.getElementById("inputs");

    if(inputs){
        inputs.addEventListener("paste", function (e) {
            let paste = (e.clipboardData || window.clipboardData).getData("text");

            let list = inputs.querySelectorAll("input");
            let i= 0;
            for (const symbol of paste) {
                if(!isNaN(parseInt(symbol))){
                    list[i].value= symbol;
                    if(i>=5)    break;
                    i++;
                }
            }
            confirmCode(e.target);
        });

        inputs.addEventListener("keyup", function (e) {
            let key = e.key;

            if (key === "backspace" || key === "delete")
                return false;

            if(isNaN(e.target.value))
                e.target.value = '';

            if (isNaN(key)) {
                e.preventDefault();
            }
            else{
                e.target.value = key;
                confirmCode(e.target);
            }
        });

        /**/
        inputs.addEventListener("keydown", function (e) {
            const target = e.target;
            const key = e.key.toLowerCase();
            if (key === "backspace" || key === "delete") {
                if(target.value !== "" ){
                    target.value = "";
                }
                else{
                    const prev = target.previousElementSibling;
                    if (prev) {
                        prev.focus();
                    }
                }
                return false;
            }
        });
        /**/

        function confirmCode(target){
            let list = inputs.querySelectorAll("input");

            let empty = Array.from(list).filter(input => input.value.trim() === '');

            if(empty.length !== 0){
                let next = target.nextElementSibling;

                if (next)
                    next.focus();
                else
                    empty[0].focus();

                return false;
            }

            let form= document.getElementById("confirmCode");
            let data= new FormData(form);
            fetch(form.getAttribute("action"),{
                method: "POST",
                body: data,
            })
                .then(response => {return response.text();})
                .then(data => {
                    data= JSON.parse(data);
                    if(data.status === "error")
                        ErrorClear();
                    else if(data.status === "success"){
                        location.href= data.page;
                    }
                });
        }

        function ErrorClear(){
            let list= inputs.querySelectorAll("input");
            list.forEach(el=> {
                el.value= '';
                el.style.animation= 'none';
                el.offsetHeight;
                el.style.animation= 'ConfirmErrorClear .5s linear';
            });
            list[0].focus();
        }


    }
});