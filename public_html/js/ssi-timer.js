document.addEventListener("DOMContentLoaded",()=>{
    let timerBox= document.getElementById("timerBox");
    if(!timerBox) return false;

    let timer= timerBox.querySelector(".timer");


    let counter = parseInt(timer.getAttribute("data-counter"));

    updateTimer(timer,counter);

    function updateTimer(timer,counter)     {
        if(counter === 0){
            timerBox.querySelector(".reverse-counter").classList.add("d-none");
            timerBox.querySelector(".resend-email").classList.remove("d-none");
            return false;
        }
        counter--;
        timer.setAttribute("data-counter",counter)
        setTimeout(
            ()=>{
                let minutes = Math.floor(counter/60);

                if(minutes<10)
                    minutes= '0'+ minutes;

                let seconds= counter%60;

                if(seconds<10)
                    seconds= '0'+ seconds;


                timer.textContent = minutes+":"+seconds;
                updateTimer(timer,counter);
            },
            1000
        );
    }

    document.getElementById("resendEmail").addEventListener("click",(evt)=>{
        evt.preventDefault();

        fetch(evt.target.href,{
            method: "GET",
        })
            .then(response => {return response.text();})
            .then(data => {
                data= JSON.parse(data);

                if(data.status === "error")
                    location.href= data.page;
                else if(data.status === "success"){
                    document.querySelectorAll("#inputs input")[0].focus();
                    updateTimer(timer,data.counter);
                    timerBox.querySelector(".reverse-counter").classList.remove("d-none");
                    timerBox.querySelector(".resend-email").classList.add("d-none");
                    return false;
                }
            });
    });


});