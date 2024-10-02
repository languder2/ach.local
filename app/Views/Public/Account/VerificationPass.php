<h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
    Verification Pass
</h5>
<div class="px-4">
    <form id="confirmCode" method="POST" action="<?=base_url(route_to("Users::ssiConfirm"))?>">
        <div class="text-center">
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
    <p class="text-center">
        Если письмо с активацией долго не приходит - проверьте папку Спам.
    </p>
    <hr>
    <div id="timerBox">
        <p class="text-center reverse-counter">
            Отправить код повторно через <span class="timer" data-counter="10">01:00    </span>
        </p>
        <p class="text-center resend-email d-none">
            <a
                    href="<?=base_url("account/verification-resend")?>"
                    class="link"
            >
                Повторно отправить письмо
            </a>
        </p>
    </div>
</div>