<form
        id              ="RecoverPassword"
        class           ="panel d-none"
        method          ="POST"
        action          ="<?=base_url(route_to("Users::RecoverPassword"))?>"
>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Не помните пароль?
    </h4>

    <div class="callout-wrapper hide mb-2">
        <div class="callout callout-error mx-2">
            error
        </div>
    </div>


    <div class="s-input-box">
        <input
                type="text"
                name="form[email]"
                id="rpEmail"
                class="form-control"
                placeholder=""
                value=""
                required
        >
        <label for="rpEmail">
            E-mail
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
                value               ="восстановить"
        >
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
    </div>
</form>