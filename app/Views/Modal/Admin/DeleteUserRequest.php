<?php if(!empty($user)):?>
    <h4 class="text-center mt-0 text-uppercase fw-bold">
        Удалить пользователя?
    </h4>
    <div class="text-center fw-bold my-2">
        UID: <?=$user->id?>
        <br>
        <?php echo $user->surname;?>
        <?php echo $user->name;?>
        <?php echo $user->patronymic;?>
        <br>
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
                href                = "<?=base_url("admin/users/delete/$user->id")?>"
                class               = "btn-main w-50"

        >
            удалить
        </a>
    </div>
<?php endif;?>
