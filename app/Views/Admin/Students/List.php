<?php
    echo view("Admin/Students/Filter",[
            "filter"    => &$filter,
            "search"    => &$search,
    ])
?>

<?php if(!empty($list)):?>

        <table class="table ">
            <caption class="px-4 py-2 bg-light">
                Студенты
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
                <th>
                </th>
            </thead>
            <tbody>
                <?php foreach($list as $student):?>
                        <tr>
                            <td class="text-center">
                                <?=$student->id?>
                            </td>
                            <td>
                                <?=$student->surname?>
                                <?=$student->name?>
                                <?=$student->patronymic?>
                            </td>
                            <td>
                                <?=$student->email?>
                            </td>
                            <td>
                                <?=$student->phone?>
                            </td>
                            <td>
                                <?php if($student->verified):?>
                                    <i class="bi bi-envelope-check-fill"></i>
                                <?php endif;?>
                            </td>
                            <td>
                                <?php if(!is_null($student->list)):?>
                                    <a href="#" class="show-students" data-uid="<?=$student->id?>">
                                        <i class="bi bi-chevron-bar-expand"></i>
                                        <i class="bi bi-chevron-bar-contract text-white"></i>
                                    </a>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php if(!is_null($student->list)):?>
                            <tr>
                                <td colspan="6" class="bg-primary d-none" data-uid="<?=$student->id?>">
                                    <?php echo view("Admin/Students/Students",[
                                        "list"          => json_decode("[$student->list]", true),
                                    ]);?>
                                </td>
                            </tr>
                        <?php endif;?>
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

    .bi-chevron-bar-contract{
        display:                    none;
    }
    .show-education-detail .bi-chevron-bar-contract{
        display:                    inline-block;
    }
    .show-education-detail .bi-chevron-bar-expand{
        display:                    none;
    }
    .show-education-detail td{
        background-color:           #0d6efd;
        color:                      white;
    }
    .bi-envelope-check-fill{
        color:                      green;
    }
    .show-education-detail .bi-envelope-check-fill{
        color:                      white;
    }

</style>