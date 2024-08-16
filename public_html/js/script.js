document.addEventListener("DOMContentLoaded",()=>{
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
})

const validateEmail = (email) => {
    return String(email)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
};

function setHeight(wrapper,inner){
    wrapper.style.height= wrapper.scrollHeight+"px";
    console.log(wrapper.scrollHeight);
    wrapper.parentElement.scrollIntoView({behavior: "smooth"});
}



/*SHOW CONTENT RADIO BUTTON*
const tabs = document.querySelectorAll('.tab-pane');
const radios = document.querySelectorAll('input[name="tab-radio"]');

radios.forEach(radio => {
    radio.addEventListener('change', () => {
        tabs.forEach(tab => {
            tab.classList.remove('show', 'active');
        });
        const targetTabId = radio.id.replace('-tab', '');
        document.getElementById(targetTabId).classList.add('show', 'active');
    });
});

const passwordInputs = document.querySelectorAll("input[type='password']");
const eyeIcons = document.querySelectorAll(".show-password img");

eyeIcons.forEach((eyeIcon, index) => {
    eyeIcon.addEventListener("click", () => {
        const passwordInput = passwordInputs[index];
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.src = "img/eye-open.png";
        } else {
            passwordInput.type = "password";
            eyeIcon.src = "img/eye-close.png";
        }
    });
});

const notFatherNameCheckbox = document.getElementById("NotFatherName");
const inputFatherName = document.getElementById("inputFatherName");

notFatherNameCheckbox.addEventListener("change", () => {
    if (notFatherNameCheckbox.checked) {
        inputFatherName.disabled = true; // Отключаем поле "Отчество"
    } else {
        inputFatherName.disabled = false; // Включаем поле "Отчество"
    }
});

/* */
