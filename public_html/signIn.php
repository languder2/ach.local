<form
        id="signIn" class="panel d-none"
>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Вход
    </h4>


    <div class="row row-cols-1 row-cols-sm-2 px-3 mx-auto">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                E-mail
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
                Телефон
            </label>
        </div>
    </div>

    <div class="s-input-box">
        <input type="text" name="form[email]" id="signInET" class="form-control" placeholder="" value="123">
        <label for="signIn">
            Email или Телефон
        </label>
    </div>

    <div class="s-input-box">
        <input type="password" name="form[password]" id="signInPass" class="form-control" placeholder="" value="">
        <label for="signInPass">
            Пароль
        </label>
    </div>

    <div class="s-input-box text-center">
        <button class="btn-main w-100">
            Войти
        </button>
    </div>

</form>
