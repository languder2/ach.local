<form
        action="signUp"
        id="signUp" class="panel d-none"
>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Регистрация
    </h4>

    <div class="callout-wrapper hide mb-2">
        <div class="callout callout-error mx-2">
        </div>
    </div>

    <div class="s-input-box">
        <input
                type                ="text"
                name                ="form[surname]"
                id                  ="suSurname"
                class               ="form-control"
                placeholder         =""
                value               =""
                data-bs-toggle      ="tooltip"
                data-bs-placement   ="bottom"
                title               =""
                required
        >
        <label for="suSurname">
            Фамилия
        </label>
    </div>

    <div class="s-input-box">
        <input
                type                ="text"
                name                ="form[name]"
                id                  ="suName"
                class               ="form-control"
                placeholder         =""
                value               =""
                data-bs-toggle      ="tooltip"
                data-bs-placement   ="bottom"
                title               =""
                required
        >
        <label for="suName">
            Имя
        </label>
    </div>

    <div class="s-input-box">
        <input
                type                ="text"
                name                ="form[patronymic]"
                id                  ="suPatronymic"
                class               ="form-control"
                placeholder         =""
                value               =""
                data-bs-toggle      ="tooltip"
                data-bs-placement   ="bottom"
                title               =""
        >
        <label for="suPatronymic">
            Отчество
        </label>
    </div>

    <div class="s-input-box">
        <input
                type                ="email"
                name                ="form[email]"
                id                  ="suEmail"
                class               ="form-control"
                placeholder         =""
                value               =""
                data-bs-toggle      ="tooltip"
                data-bs-placement   ="bottom"
                title               =""
                required
        >
        <label for="suEmail">
            E-mail
        </label>
    </div>

    <div class="s-input-box">
        <input
                type                ="password"
                name                ="form[password]"
                id                  ="suPass"
                class               ="form-control"
                placeholder         =""
                value               =""
                data-bs-toggle      ="tooltip"
                data-bs-placement   ="bottom"
                title               =""
                required
        >
        <label for="suPass">
            Пароль
        </label>
    </div>

    <div class="s-input-box">
        <input
                type                ="password"
                name                ="form[retry]"
                id                  ="suRetry"
                class               ="form-control"
                placeholder         =""
                value               =""
                data-bs-toggle      ="tooltip"
                data-bs-placement   ="bottom"
                title               =""
                required
        >
        <label for="suRetry">
            Повторить пароль
        </label>
    </div>

    <div class="s-input-box text-center btn-grp">
        <a
                href                ="#"
                class               ="btn-main w-20 show-modal"
                data-action         ="#signIn"
        >
            <i class="bi bi-arrow-left"></i>
        </a>
        <input
                type                ="submit"
                class               ="btn-main w-80"
                value               ="Продолжить"
        >
    </div>

    <div class="form-check ps-3 pe-2 mx-4 my-2">
        <input
                type                ="checkbox"
                name                ="form[agreement]"
                id                  ="suAgreement"
                value               ="1"
                class               ="form-check-input"
                required
                checked
        >
        <label class="form-check-label fs-.75" for="suAgreement">
            Нажимая кнопку «Продолжить», я даю свое согласие на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных в Согласии на обработку персональных данных<span class="color:red">*</span>
        </label>
    </div>




</form>
