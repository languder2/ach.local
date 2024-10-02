<div class="mw-md-50rem mx-auto">
    <h3 class="page-title mb-4">
        Личный кабинет
    </h3>

    <?php if(isset($message)):?>
        <div class="callout mb-4 callout-<?=$message->status??""?> bg-white shadow-box-st ">
            <?=$message->content??""?>
        </div>
    <?php endif;?>

    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-1 g-0">
        <div class="col">
            <?php if(isset($user) && $user->verified === "0"):?>
                <div class="bg-white py-3 rounded-4 shadow-box-st mb-4">
                    <?php
                    if(isset($verification))
                        echo view("Public/Account/VerificationPass",[
                            "user"      => &$user
                        ]);
                    else
                        echo view("Public/Account/VerificationRequest",[
                            "user"      => &$user
                        ]);

                    ?>
                </div>
            <?php endif;?>
            <div class="bg-white py-3 rounded-4 mb-4 shadow-box-st">
                <?php echo view("Public/Account/PersonalPanel",[
                    "user"      => &$user
                ])?>
            </div>
        </div>

        <div class="col">
            <div class="bg-white py-3 rounded-4 shadow-box-st mb-4">
                <?php echo view("Public/Account/EducationPanel",[
                    "user"      => &$user
                ])?>
            </div>
        </div>
    </div>
</div>