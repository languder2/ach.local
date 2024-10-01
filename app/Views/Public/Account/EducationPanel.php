<?php if(isset($user)):?>
    <h5 class="pe-4 ps-5 pb-2 border-bottom border-1">
        Учебные данные
    </h5>
    <div class="px-4 px-md-5">
        <div class="container-fluid">
            <div class="row row-cols-2 g-3">
                <div class="col">
                    ФИО:
                </div>
                <div class="col">
                    <?php echo $user->surname??"" ?>
                    <?php echo $user->name??"" ?>
                    <?php echo $user->patronymic??"" ?>
                </div>
                <div class="col">
                    E-mail:
                </div>
                <div class="col">
                    <?php echo $user->email??"" ?>
                </div>
                <div class="col">
                    Телефон
                </div>
                <div class="col">
                    <?php echo $user->phone??"" ?>
                </div>
            </div>
        </div>
    </div>

<?php endif;?>