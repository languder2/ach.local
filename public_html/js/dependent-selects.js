document.addEventListener("DOMContentLoaded",() => {
    let dsFaculty       = document.querySelector('select[data-ds="faculty"]');
    let dsLevel         = document.querySelector('select[data-ds="level"]');

    if(dsFaculty === null)  return false;
    if(dsLevel === null)    return false;

    dsFaculty.addEventListener("change",(evt)=>{
        let value                           = evt.target.value;
        let list        = document.querySelectorAll('option[data-faculty]');
        list.forEach(el=>{
            if(el.getAttribute('data-faculty') === value){
                el.removeAttribute("disabled");
                el.classList.remove("ds-hidden-faculty");
            }
            else{
                el.setAttribute("disabled","true");
                el.classList.add("ds-hidden-faculty");
            }
        });
        checkDisabled();
    });

    dsLevel.addEventListener("change",(evt)=>{
        let value                           = evt.target.value;
        let list        = document.querySelectorAll('option[data-level]');
        list.forEach(el=>{
            if(el.getAttribute('data-level') === value){
                el.classList.remove("ds-hidden-level");
            }
            else{
                el.classList.add("ds-hidden-level");
            }
        });
        checkDisabled();
    });

    function checkDisabled(){
        let list = document.querySelectorAll('option[data-faculty]');
        list.forEach(el=>{
            if(el.classList.contains('ds-hidden-faculty') || el.classList.contains('ds-hidden-level'))
                el.setAttribute("disabled","true");
            else
                el.removeAttribute("disabled");
        });

        let dsSpeciality       = document.querySelector('select[data-ds="speciality"]');
        if(dsSpeciality.options[dsSpeciality.selectedIndex].getAttribute("disabled"))
            dsSpeciality.value = '';

        let dsDepartment       = document.querySelector('select[data-ds="department"]');
        if(dsDepartment.options[dsDepartment.selectedIndex].getAttribute("disabled"))
            dsDepartment.value = '';
    }
 });
