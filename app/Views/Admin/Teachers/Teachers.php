<?php if(!empty($list) and count($list)):?>
    <table class="table mb-0">
        <thead>
        <th class="text-center">
            faculty
        </th>
        <th>
            department
        </th>
        <th>
            level
        </th>
        <th>
            form
        </th>
        <th>
            code
        </th>
        <th>
            spec
        </th>
        <th>
            course
        </th>
        <th>
            group
        </th>
        </thead>
        <tbody>
        <?php foreach($list as $student):?>
            <?php $student = (object)$student;?>
            <?php if(empty($student->faculty)) continue; ?>
            <tr>
                <td class="text-center">
                    <?=$student->faculty?>
                </td>
                <td>
                    <?=$student->department?>
                </td>
                <td>
                    <?=$student->level?>
                </td>
                <td>
                    <?=$student->form?>
                </td>
                <td>
                    <?=$student->code?>
                </td>
                <td>
                    <?=$student->speciality?>
                </td>
                <td>
                    <?=$student->course?>
                </td>
                <td>
                    <?=$student->group?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php else:?>
    123
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