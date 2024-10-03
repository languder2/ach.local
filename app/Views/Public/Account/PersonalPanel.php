<h5 class="px-4 px-md-5 pb-2 border-bottom border-1">
    Персональные данные
</h5>
<div class="px-4 px-md-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                ФИО:
            </div>
            <div class="col-12 col-sm-8 mb-3">
                <?php echo $user->surname??"" ?>
                <?php echo $user->name??"" ?>
                <?php echo $user->patronymic??"" ?>
            </div>

            <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                E-mail:
            </div>
            <div class="col-12 col-sm-8 mb-3">
                <?php echo $user->email??"" ?>
            </div>

            <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                Телефон
            </div>
            <div class="col-12 col-sm-8 mb-3">
                <?php echo $user->phone??"" ?>
            </div>

            <p class="text-center text-md-end">
                <a href="<?=base_url("account/change-personal")?>" class="link d-inline-block">
                    изменить данные
                </a>
            </p>
        </div>
    </div>
</div>
