<section class="page">
    <div class="grid-cell">
        <div class="block-auth mw-30rem mx-auto mt-0 px-4 py-4 rounded-4 bg-white">
            <form
                    id              ="si"
                    class           ="panel"
                    method          ="POST"
                    action          ="<?=base_url(route_to("Pages::auth"))?>"
            >
                <h4 class="text-center mt-0 text-uppercase fw-bold">
                    Вход
                </h4>

                <?php if(!empty($message)):?>
                    <div class="callout-wrapper mb-2">
                        <div class="callout callout-error mx-2">
                            <?=$message->content??""?>
                        </div>
                    </div>
                <?php endif;?>



                <div class="s-input-box">
                    <input
                            type="text"
                            name="form[login]"
                            id="siLogin"
                            class="form-control"
                            placeholder=""
                            value=""
                            required
                    >
                    <label for="siLogin">
                        E-mail или Логин
                    </label>
                </div>

                <div class="s-input-box">
                    <input
                            type="password"
                            name="form[password]"
                            id="siPass"
                            class="form-control"
                            placeholder=""
                            value=""
                            required
                    >
                    <label for="siPass">
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
        </div>
    </section>
</div>