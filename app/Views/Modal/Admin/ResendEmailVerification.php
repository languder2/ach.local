<?php if(!empty($user)):?>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Верификация
    </h4>
    <div class="text-center">
        Отправить повторно письмо верификации?<br>
    </div>
    <div class="text-center fw-bold my-2">
            <?php echo $user->email;?>
    </div>
    <div class="s-input-box text-center btn-grp">
        <a
                href                = "#"
                class               = "btn-main w-50"
                onclick             = "return closeModal();"
        >
            отмена
        </a>
        <a
                href                = "#"
                class               = "btn-main w-50"
                onclick             = "return modalAction(this);"
                data-action         = <?=base_url("admin/resend-verification/$user->id")?>
        >
            отправить
        </a>
    </div>
<?php endif;?>
