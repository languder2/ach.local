<h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
    Верификация
</h5>
<div class="px-4">
    <h3 class="text-center color:red">
        Указанный Вами E-mail не подтвержден
    </h3>
    <p class="text-center resend-email my-3">
        <a
                href="<?=base_url("account/verification-request")?>"
                id="resendEmail"
                class="btn-main d-inline-block"
        >
            подтвердить почту
        </a>
    </p>
    <hr>
    <p class="text-center">
        На указанную Вами почту
        <b><?=$user->email??""?></b>
        письмо с кодом и инструкцией.
        <br>
        Пожалуйста, проверьте свою почту и следуйте инструкциям в письме.
    </p>
</div>