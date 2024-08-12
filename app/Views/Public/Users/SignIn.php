<form
        id="signIn" class="panel d-none"
>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Вход
    </h4>

    <div class="s-input-box">
        <input type="text" name="form[email]" id="signInET" class="form-control" placeholder="" value="">
        <label for="signIn">
            E-mail
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

    <div class="p-2 text-center fs-1.10 lh-lg">
        <span class="d-inline-block">
            Нет аккаунта?
        </span>
        <a
            href="#"
            class="link show-modal"
            data-action="#signUp"
        >
            Зарегистрироваться
        </a>
        <br>
        <a
            href="#"
            class="link"
            data-action="#sign"
        >
            Не помню пароль
        </a>
    </div>
</form>
