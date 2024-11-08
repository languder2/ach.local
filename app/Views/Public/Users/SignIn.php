<form
        id              ="signIn"
        class           ="panel d-none"
        method          ="POST"
        action          ="<?=base_url(route_to("Users::authSI"))?>"
>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Вход
    </h4>

    <div class="callout-wrapper hide mb-2">
        <div class="callout callout-error mx-2">
            error
        </div>
    </div>


    <div class="s-input-box">
        <input
                type="text"
                name="form[login]"
                id="signInET"
                class="form-control"
                placeholder=""
                value=""
                required
        >
        <label for="signInET">
            E-mail или Логин
        </label>
    </div>

    <div class="s-input-box">
        <input
                type="password"
                name="form[password]"
                id="signInPass"
                class="form-control"
                placeholder=""
                value=""
                required
        >
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
            <!--

            href="<?=base_url("students")?>"
            class="link"

                href="#"
                class="link show-modal"
                data-action="#signUp"
            -->
        </a>

        <br>
        <a
                href="#"
                class="link show-modal"
                data-action="#RecoverPassword"
        >
            Не помню пароль
        </a>
    </div>
</form>
