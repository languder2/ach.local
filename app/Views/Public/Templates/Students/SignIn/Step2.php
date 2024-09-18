<form id="confirmCode" method="POST" action="<?=base_url(route_to("Users::ssiConfirm"))?>">
    <h4 class="
                text-center border-bottom border-1 pb-3
    ">
        Регистрация в системе дистанционного обучения
    </h4>
    <div class="text-center fs-1.25">
        Введите код присланный на <b><?=$user->email??""?></b>
    </div>
    <div class="container-fluid" >
        <input type="hidden" name="email" value="<?=$user->email??""?>">
        <div class="text-center confirm-code d-flex">
            <label id="inputs" class="inputs d-block mx-auto">
                <input name="code[]" type="text" inputmode="numeric" maxlength="1" autofocus/>
                <input name="code[]" type="text" inputmode="numeric" maxlength="1" />
                <input name="code[]" type="text" inputmode="numeric" maxlength="1" />
                <input name="code[]" type="text" inputmode="numeric" maxlength="1" />
                <input name="code[]" type="text" inputmode="numeric" maxlength="1" />
                <input name="code[]" type="text" inputmode="numeric" maxlength="1" />
            </label>
        </div>
    </div>
</form>
<hr>
<p class="text-center fs-1.25">
    Если письмо с активацией долго не приходит<br>проверьте папку Спам.
</p>
<hr>
<div id="timerBox">
    <p class="fs-1.25 text-center reverse-counter">
        Отправить код повторно через <span class="timer" data-counter="60">01:00    </span>
    </p>
    <p class="text-center resend-email d-none">
        <a
            href="<?=base_url(route_to("Users::ssiResendEmail"))?>"
            id="resendEmail"
            class="link fs-1.25"
        >
            Повторно отправить письмо
        </a>
    </p>
</div>
<hr>
<div class="text-center">
    <a
        href="<?=base_url(route_to("Users::ssiChangeData"))?>"
        class="link fs-1.25"
    >
        Использовать другие данные
    </a>
</div>

