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