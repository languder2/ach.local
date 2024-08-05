window.onload = function() {
    const daySelect = document.getElementById("daySelect");
    const monthSelect = document.getElementById("monthSelect");
    const yearSelect = document.getElementById("yearSelect");

    const months = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
    console.log(months.length);
    for (let i = 0; i < months.length; i++) {
        const option = document.createElement("option");
        option.value = i + 1;
        option.text = months[i];
        monthSelect.add(option);
    }

    const currentYear = new Date().getFullYear();
    for (let i = 1900; i <= currentYear; i++) {
        const option = document.createElement("option");
        option.value = i;
        option.text = i;
        yearSelect.add(option);
    }

    function createDays() {
        daySelect.innerHTML = '';

        const firstOption = document.createElement("option");
        firstOption.value = "";
        firstOption.text = "День";
        daySelect.add(firstOption);

        for (let i = 1; i <= 31; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.text = i;

            daySelect.add(option);
        }
    }

    createDays();

};