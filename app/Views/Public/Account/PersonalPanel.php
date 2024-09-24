<h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
    Персональные данные
</h5>
<form id="ssiStep1" class="px-4 pt-2" method="POST" action="<?=base_url("account/change-info")?>">

    <input type="hidden" name="type" value="personal">

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
        <label for="messenger">
            Мессенджер
        </label>
    </div>

    <div class="s-input-box text-center">
        <button class="d-inline-block btn-main w-50">
            далее
        </button>
    </div>
</form>
