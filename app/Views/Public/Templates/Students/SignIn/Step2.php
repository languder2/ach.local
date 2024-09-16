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
                <input name="code[]" type="text" inputmode="numeric" maxlength="1" />
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
<p class="fs-1.25 text-center">
    Отправить код повторно через <span class="timer">00:59</span>
</p>
<hr>
<div class="text-center">
    Использовать другие данные
</div>

<!----
<div class="s-input-box text-center btn-grp">
    <a href="#" class="btn-main w-50 show-modal" data-action="#signIn">
        изменить данные
    </a>
    <a href="#" class="btn-main w-50 show-modal" data-action="#signIn">
        отправить повторно
    </a>
</div>
!---->
