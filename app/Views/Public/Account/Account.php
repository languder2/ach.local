<div class="mw-md-50rem mx-auto">
    <h3 class="page-title mb-4">
        Личный кабинет
    </h3>

    <?php if(isset($message)):?>
        <div class="callout mb-4 callout-<?=$message->status??""?> bg-white shadow-box-st ">
            <?=$message->content??""?>
        </div>
    <?php endif;?>

    <?php if(!empty($eventList)):?>
        <div class="bg-white py-3 rounded-4 shadow-box-st mb-4">
            <?php
                echo view("Public/Account/EventList",[
                    "list"      => &$eventList
                ]);
            ?>
        </div>
    <?php endif;?>

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

    <?php if(in_array("teacher",$user->roles)):?>
        <div class="bg-white py-3 rounded-4 mb-4 shadow-box-st">
            <h5 class="px-4 px-md-5 pb-2 border-bottom border-1">
                Данные СДО
            </h5>
            <?php if(empty($user->moodle)):?>
                <?php echo view("Public/Account/SDORequestPanel",[
                    "user"      => &$user
                ])?>
            <?php else:?>
                <?php echo view("Public/Account/SDOPanel",[
                    "user"      => &$user
                ])?>
            <?php endif;?>
        </div>
    <?php endif;?>


    <div class="bg-white py-3 rounded-4 shadow-box-st mb-4">
        <?php echo view("Public/Account/EducationPanel",[
            "user"      => &$user
        ])?>
    </div>
</div>