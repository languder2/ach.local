<?php
    echo view("Admin/Teachers/Filter",[
            "filter"    => &$filter,
            "search"    => &$search,
    ])
?>

<?php if(!empty($list)):?>

        <table class="table ">
            <caption class="px-4 py-2 bg-light">
                Преподаватели
            </caption>
            <thead>
                <th class="text-center">
                    #
                </th>
                <th>
                    ФИО
                </th>
                <th>
                    E-mail / Phones
                </th>
                <th>
                    moodle
                </th>
                <th colspan="4">
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
                            </td>
                            <td>
                                <?=$user->email?>
                                <br>
                                <?=$user->phone?>
                            </td>
                            <td>
                                <?=$user->moodle?>
                            </td>

                            <td>
                                <a
                                        href        = "<?=base_url("/modal/admin-verification-resend/$user->id")?>"
                                        class       = "modal-action fs-4"
                                        data-action = "#message"
                                >
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                            </td>

                            <td>
                                <?php if($user->verified):?>
                                    <i class="bi bi-envelope-check fs-4 color:green"></i>
                                <?php else:?>
                                    <a
                                        href        = "<?=base_url("/modal/admin-verification-resend/$user->id")?>"
                                        class       = "modal-action fs-4"
                                        data-action = "#message"
                                    >
                                        <i class="bi bi-envelope-x fs-4 color:red"></i>
                                    </a>
                                <?php endif;?>
                            </td>

                            <td>
                                <?php if($user->muid):?>
                                    <i class="bi bi-person-check fs-4 color:green"></i>
                                <?php else:?>
                                    <a
                                        href        = "<?=base_url("/modal/admin-verification-resend/$user->id")?>"
                                        class       = "modal-action fs-4"
                                        data-action = "#message"
                                    >
                                        <i class="bi bi-person-plus color:red"></i>
                                    </a>
                                <?php endif;?>
                            </td>

                            <td>
                                <?php if($user->muid):?>
                                    <a
                                        href        = "<?=base_url("/modal/admin-change-moodle-pass/$user->id")?>"
                                        class       = "modal-action fs-4"
                                        data-action = "#message"
                                    >
                                        <i class="bi bi-key"></i>
                                    </a>
                                <?php endif;?>
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
