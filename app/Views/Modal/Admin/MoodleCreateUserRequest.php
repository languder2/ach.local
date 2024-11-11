<?php if(!empty($user)):?>
    <form
            class       = "px-4 pt-2"
            method      = "POST"
            action      = "<?=base_url("api/moodle/AdminMoodleCreate")?>"
            onsubmit    = "return modalFormSubmit(this);"
    >
        <h4 class="text-center mt-0 text-uppercase fw-bold">
            Аккаунт СДО
        </h4>
        <div class="text-center">
            Создать пользователя СДО<br>
        </div>
        <div class="text-center fw-bold my-2">
            <?php echo $user->surname;?>
            <?php echo $user->name;?>
            <?php echo $user->patronymic;?>
            <br>
            (<?php echo $user->email;?>)
        </div>

        <div class="callout callout-error mx-2 d-none">
        </div>

        <input type="hidden" name="form[uid]" value="<?=$user->id?>">

        <div class="s-input-box">
            <input
                    type="text"
                    name="form[login]"
                    id="moodleLogin"
                    class="form-control"
                    placeholder=""
                    value="<?=$login??""?>"
                    required
            >
            <label for="ssiPatronymic">
                Логин в СДО
            </label>
        </div>

        <div class="s-input-box text-center btn-grp">
            <a
                    href                = "#"
                    class               = "btn-main w-50"
                    onclick             = "return closeModal();"
            >
                отмена
            </a>
            <button
                    class               = "btn-main w-50"
            >
                создать
            </button>
        </div>
    </form>

<?php endif;?>
