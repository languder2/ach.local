<?php
    echo view("Admin/Users/Filter",[
            "filter"        => &$filter,
    ])
?>

<?php echo view("Admin/Users/Actions",[]);?>
<?php if(isset($message)):?>
    <div class="callout callout-<?=$message->status??""?> my-3 bg-white">
        <?php echo $message->message??"";?>
    </div>
<?php endif;?>

<?php if(!empty($list)):?>

        <table class="table ">
            <caption class="px-4 py-2 bg-light">
                Пользователи: <?=$total??""?>
            </caption>
            <thead>
                <th class="text-center">
                    #
                </th>
                <th>
                    ФИО / E-mail / Phones
                </th>
                <th>
                    Роли
                </th>
                <th colspan="5">
                </th>
            </thead>
            <tbody>
                <?php foreach($list as $user):?>
                        <tr>
                            <td class="text-center">
                                <?=$user->id?>
                            </td>
                            <td>
                                <?=$user->surname?>
                                <?=$user->name?>
                                <?=$user->patronymic?>
                                <br>
                                <?=$user->email?>
                                <br>
                                <?=$user->phone?>
                            </td>
                            <td>
                                <?php echo implode("<br>",$user->roles??[])?>
                            </td>
                            <td>
                                <a
                                        href        = "<?=base_url("admin/users/$user->id")?>"
                                        class       = "fs-4"
                                        title       = "анкета"
                                >
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                            </td>

                            <td>
                                <?php if($user->verified):?>
                                    <i
                                        class       = "bi bi-envelope-check fs-4 color:green"
                                        title       = "Пользователь верифицирован"
                                    ></i>
                                <?php else:?>
                                    <a
                                        href        = "<?=base_url("/modal/admin-verification-resend/$user->id")?>"
                                        class       = "modal-action fs-4"
                                        data-action = "#message"
                                        title       = "Отправить письмо верификации"
                                    >
                                        <i class="bi bi-envelope-x fs-4 color:red"></i>
                                    </a>
                                <?php endif;?>
                            </td>

                            <td>
                                <?php if($user->muid):?>
                                    <i
                                        class="bi bi-person-check fs-4 color:green"
                                        title       = "in moodle"
                                    ></i>
                                <?php else:?>
                                    <a
                                        href        = "<?=base_url("/modal/admin-moodle-create-user/$user->id")?>"
                                        class       = "modal-action fs-4"
                                        data-action = "#message"
                                        title       = "add to the moodle"
                                    >
                                        <i class="bi bi-person-plus color:red"></i>
                                    </a>
                                <?php endif;?>
                            </td>

                            <td>
                                <?php if($user->muid):?>
                                    <a
                                        href        = "<?=base_url("/modal/admin-moodle-change-pass/$user->id")?>"
                                        class       = "modal-action fs-4"
                                        data-action = "#message"
                                        title       = "moodle change pass"
                                    >
                                        <i class="bi bi-key"></i>
                                    </a>
                                <?php endif;?>
                            </td>
                            <td>
                                <a
                                        href        = "<?=base_url("/modal/admin-delete-user/$user->id")?>"
                                        class       = "modal-action fs-4"
                                        data-action = "#message"
                                        title       = "удалить пользователя"
                                >
                                    <i class="bi bi-person-dash fs-4"></i>
                                </a>
                            </td>
                        </tr>
                <?php endforeach;?>
            </tbody>
        </table>

    <?php
        if(isset($pager)) echo $pager;
    ?>
<?php endif;?>

<style>
    table{
        caption-side:               top;
    }
    table caption{
        font-size:                  1.5rem;
        background-color:           yellow;
    }

</style>
