<?php if(isset($list) && is_array($list)):?>
    <table style="width: 100%">
    <?php foreach ($list as $key=>$item):?>
        <?php if($key === 0):?>
            <thead>
                <tr>
                    <th>#</th>
                    <?php foreach ($item as $field => $value):?>
                        <th>
                            <?=$field?>
                        </th>
                    <?php endforeach;?>
                </tr>
            </thead>
        <?php endif;?>
        <tr>
            <th><?=$key+1?></th>
            <?php foreach ($item as $field => $value):?>
                <td>
                    <?=$value?>
                </td>
            <?php endforeach;?>
        </tr>

    <?php endforeach;?>
    </table>
<?php endif;?>
