<form
        id              = "askQuestion"
        class           = "panel d-none"
        method          = "POST"
        action          = "<?=base_url("ask-question")?>"
>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Задать вопрос
    </h4>

    <div class="callout-wrapper hide mb-2">
        <div class="callout callout-error mx-2">
            error
        </div>
    </div>


    <div class="s-input-box">
        <input
                type            = "text"
                name            = "form[name]"
                id              = "aqName"
                class           = "form-control"
                placeholder     = ""
                value           = "<?= empty($user)?"":"$user->surname $user->name $user->patronymic"?>"
                required
        >
        <label for="aqName">
            Введите ваше имя<span class="color:red">*</span>
        </label>
    </div>
    <div class="s-input-box">
        <input
                type            = "text"
                name            = "form[email]"
                id              = "aqEmail"
                class           = "form-control"
                placeholder     = ""
                value           = "<?= empty($user)?"":"$user->email"?>"
                required
        >
        <label for="aqEmail">
            Введите ваш E-mail<span class="color:red">*</span>
        </label>
    </div>
    <div class="s-input-box">
        <textarea
                name            = "form[question]"
                id              = "aqQuestion"
                class           = "form-control"
                placeholder     = ""
                required
        ></textarea>
        <label for="aqQuestion">
            Введите Ваш вопрос<span class="color:red">*</span>
        </label>
    </div>

    <div class="s-input-box text-center">
        <input
                type                ="submit"
                class               ="btn-main w-100"
                value               ="отправить"
        >
    </div>
</form>
