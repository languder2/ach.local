<form
        id="signUp" class="panel d-none"
>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Регистрация
    </h4>

    <div class="s-input-box">
        <input type="text" name="form[surname]" id="suSurname" class="form-control" placeholder="" value="" required>
        <label for="suSurname">
            Фамилия
        </label>
    </div>

    <div class="s-input-box">
        <input type="text" name="form[name]" id="suName" class="form-control" placeholder="" value="" required>
        <label for="suName">
            Имя
        </label>
    </div>

    <div class="s-input-box">
        <input type="text" name="form[patronymic]" id="suPatronymic" class="form-control" placeholder="" value="">
        <label for="suPatronymic">
            Отчество
        </label>
    </div>

    <div class="s-input-box">
        <input type="email" name="form[email]" id="suEmail" class="form-control" placeholder="" value="" required>
        <label for="suEmail">
            E-mail
        </label>
    </div>

    <div class="s-input-box">
        <input type="password" name="form[password]" id="suPass" class="form-control" placeholder="" value="" required>
        <label for="suPass">
            Пароль
        </label>
    </div>

    <div class="s-input-box">
        <input type="password" name="form[retry]" id="suRetry" class="form-control" placeholder="" value="" required>
        <label for="suRetry">
            Повторить пароль
        </label>
    </div>

    <div class="form-check px-2 mx-4 my-2">
        <input class="form-check-input" type="checkbox" value="" id="suAgreement" required>
        <label class="form-check-label" for="suAgreement">
            Я принимаю условия пользовательского соглашения
        </label>
    </div>

    <div class="form-check px-2 mx-4 my-2">
        <input class="form-check-input" type="checkbox" value="" id="suDaraProcessing" required>
        <label class="form-check-label" for="suDaraProcessing">
            Я даю согласие на обработку моих персональных данных на условиях, определённых политикой обработки персональных данных
        </label>
    </div>

    <div class="s-input-box text-center btn-grp">
        <a
                href="#"
                class="btn-main w-20 show-modal"
                data-action="#signIn"
        >
            <i class="bi bi-arrow-left"></i>
        </a>
        <input
                type="submit"
                class="btn-main w-80"
                value="Зарегистрироваться"
        >
    </div>

</form>
