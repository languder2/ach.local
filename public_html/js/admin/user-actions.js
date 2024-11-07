document.addEventListener("DOMContentLoaded", ()=>{

    let modalContent    = document.querySelector("#modal #modalContent");
    if(modalContent === null) return false;

    let list    = document.querySelectorAll(".modal-action");
    if(!list.length) return false;

    list.forEach(el => {
        el.addEventListener("click", e=> {
            e.preventDefault();

            fetch(el.getAttribute("href"),{
                method:         "GET",
            })
                .then(response => {return response.text();})
                .then(data => {
                    data= JSON.parse(data);
                    if(data.code === 200){
                        modalContent.querySelector("#message").innerHTML = data.html;
                        showModal("#message");
                    }
                });
        });

    });
});