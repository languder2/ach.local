<form id="ssiStep1" method="POST" action="<?=route_to("Users::ssiProcessing")?>">
    <h4 class="
                text-center border-bottom border-1 pb-3
    ">
        Регистрация в системе дистанционного обучения
    </h4>
    <?php if(isset($message)):?>
        <div class="callout-wrapper">
            <div class="callout callout-error mx-.75">
                <?=$message?>
            </div>
        </div>

    <?php endif;?>
    <div class="s-input-box">
        <input
                type="text"
                name="form[surname]"
                id="ssiSurname"
                class="form-control"
                placeholder=""
                value="<?=$form->surname??""?>"
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
                value="<?=$form->name??""?>"
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
                value="<?=$form->patronymic??""?>"
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
                value="<?=$form->email??""?>"
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
                value="<?=$form->phone??""?>"
        >
        <label for="ssiPhone">
            Телефон
        </label>
    </div>
    <div class="s-input-box">
        <input
                type                ="password"
                name                ="form[password]"
                id                  ="suPass"
                class               ="form-control"
                placeholder         =""
                value               =""
                data-bs-toggle      ="tooltip"
                data-bs-placement   ="bottom"
                title               =""
                autocomplete        ="false"
                required
        >
        <label for="suPass">
            Пароль
        </label>
    </div>

    <div class="s-input-box">
        <input
                type                ="password"
                name                ="form[confirm]"
                id                  ="suConfirm"
                class               ="form-control"
                placeholder         =""
                value               =""
                data-bs-toggle      ="tooltip"
                data-bs-placement   ="bottom"
                title               =""
                autocomplete        ="false"
                required
        >
        <label for="suRetry">
            Повторить пароль
        </label>
    </div>

    <div class="form-check ps-3 pe-0 mx-4 my-2">
        <input type="checkbox" name="form[agreement]" id="suAgreement" value="1" class="form-check-input" required="" checked>
        <label class="form-check-label fs-.75" for="suAgreement">
            Нажимая кнопку «Отправить», я даю свое согласие на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных в Согласии на обработку персональных данных<span class="color:red">*</span>
        </label>
    </div>


    <div class="s-input-box text-center">
        <button class="d-inline-block btn-main w-50">
            далее
        </button>
    </div>
</form>
