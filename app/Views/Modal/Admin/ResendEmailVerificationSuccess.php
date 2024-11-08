<?php if(!empty($user)):?>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Верификация
    </h4>
    <div class="text-center">
        Письмо отправлено
    </div>
    <div class="text-center fw-bold my-2">
            <?php echo $user->email;?>
    </div>
    <div class="s-input-box text-center">
        <a
                href                = "#"
                class               = "btn-main w-50 mx-auto"
                onclick             = "return closeModal();"
        >
            Закрыть
        </a>
    </div>
<?php endif;?>
