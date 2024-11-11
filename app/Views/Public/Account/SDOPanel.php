<?php if(isset($user->moodle)):?>
    <div class="px-4 px-md-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                    Login:
                </div>
                <div class="col-12 col-sm-8 mb-3">
                    <?=$user->moodle->login?>
                </div>

                <div class="col-12 col-sm-4 mb-sm-3 fw-semibold">
                    E-mail:
                </div>
                <div class="col-12 col-sm-8 mb-3">
                    <?=$user->moodle->email?>
                </div>

                <p class="text-center text-md-end">
                    <a href="<?=base_url("account/moodle-get-new-pass")?>" class="link d-inline-block">
                        Запросить новый пароль в СДО
                    </a>
                </p>
            </div>
        </div>
    </div>
<?php endif;?>