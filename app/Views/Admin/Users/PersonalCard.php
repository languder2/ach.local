<div class="mw-md-50rem mx-auto bg-white py-3 rounded-4 mb-4 shadow-box-st">
    <h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
        Персональные данные
    </h5>

    <form class="px-4 pt-2" method="POST" action="<?=base_url("admin/users/".(isset($user->id)?"save":"create"))?>">

        <?php if(isset($message)):?>
            <div class="callout callout-<?=$message->status??""?> mx-2">
                <?php echo $message->message??"";?>
            </div>
        <?php endif;?>

        <input type="hidden" name="uid" value="<?=$user->id??""?>">

        <label class="s-input-box w-100">

            <select name="form[roles][]" class="form-select" multiple size="3" required>
                <?php foreach ($roles??[] as $role):?>
                    <option
                        <?=in_array($role,$user->roles??[])?"selected":""?>
                    >
                        <?=$role?>
                    </option>
                <?php endforeach;?>
            </select>
        </label>

        <div class="s-input-box">
            <input
                    type="text"
                    name="form[surname]"
                    id="ssiSurname"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->surname??""?>"
                    required
            >
            <label for="ssiSurname">

                Фамилия<span class="color:red">*</span>
            </label>
        </div>
        <div class="s-input-box">
            <input
                    type="text"
                    name="form[name]"
                    id="ssiName"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->name??""?>"
                    required
            >
            <label for="ssiName">
                Имя<span class="color:red">*</span>
            </label>
        </div>
        <div class="s-input-box">
            <input
                    type="text"
                    name="form[patronymic]"
                    id="ssiPatronymic"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->patronymic??""?>"
            >
            <label for="ssiPatronymic">
                Отчество
            </label>
        </div>
        <div class="s-input-box">
            <input
                    type="email"
                    name="form[email]"
                    id="ssiEmail"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->email??""?>"
                    required
            >
            <label for="ssiEmail">
                E-mail<span class="color:red">*</span>
            </label>
        </div>
        <div class="s-input-box">
            <input
                    type="tel"
                    name="form[phone]"
                    id="ssiPhone"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->phone??""?>"
            >
            <label for="ssiPhone">
                Телефон
            </label>
        </div>

        <div class="s-input-box">
            <input
                    type="text"
                    name="form[messenger]"
                    id="ssiMessenger"
                    class="form-control"
                    placeholder=""
                    value="<?=$user->messenger??""?>"
            >
            <label for="ssiMessenger">
                Мессенджер
            </label>
        </div>

        <?php if(!isset($user->id)):?>

            <div class="form-check my-2 px-2 ms-4">
                <input
                        name    = "form[sdo]"
                        class   = "form-check-input"
                        type    = "checkbox"
                        value   = "true"
                        id      = "flexCheckIndeterminate"
                        <?=isset($user->sdo)?"checked":""?>
                >
                <label class="form-check-label" for="flexCheckIndeterminate">
                    Создать пользователя в СДО Moodle
                </label>
            </div>
            <p class="notice px-2 my-2">
                Пароль будет сгенерирован автоматически и указан в уведомлении на почту.
            </p>
        <?php endif;?>

        <div class="s-input-box text-center">
            <button class="d-inline-block btn-main w-50">
                далее
            </button>
        </div>
    </form>
</div>