<form class="px-4 pt-2" method="POST" action="<?=base_url("api/moodle/UserCreate")?>">
    <p class="px-3">
        Укажите желаемый логин для регистрации в системе.<br>
    </p>

    <div class="s-input-box">
        <input
                type="text"
                name="form[login]"
                id="moodleLogin"
                class="form-control"
                placeholder=""
                value="<?=$user->moodle->login??""?>"
                required
        >
        <label for="ssiPatronymic">
            Логин в СДО
        </label>
    </div>

    <div class="s-input-box text-center">
        <button class="d-inline-block btn-main w-50">
            Зарегистрировать с СДО
        </button>
    </div>

    <p class="px-3 text-center">
        По результатам проверки не занятости аккаунта на указанную Вами почту
        <b><?=$user->email??""?></b> будет выслано письмо с формированным паролем
    </p>
</form>
