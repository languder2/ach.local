/*SHOW CONTENT RADIO BUTTON*/
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