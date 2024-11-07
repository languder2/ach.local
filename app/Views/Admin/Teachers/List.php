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
                    E-mail
                </th>
                <th>
                    Телефон
                </th>
                <th>
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
                            </td>
                            <td>
                                <?=$user->phone?>
                            </td>
                            <td>
                                <?php if($user->verified):?>
                                    <i class="bi bi-envelope-check color:green"></i>
                                <?php else:?>
                                    <a
                                        href        = "<?=base_url("/modal/admin-verification-resend/$user->id")?>"
                                        class       = "modal-action"
                                        data-action = "#message"
                                    >
                                        <i class="bi bi-envelope-x color:red"></i>
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
