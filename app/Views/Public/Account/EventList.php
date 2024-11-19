<h5 class="px-4 px-md-5 pb-2 border-bottom border-1">
    Запись на мероприятие
</h5>
<div class="px-4 px-md-5">
    <div class="container-fluid">
        <?php if(!empty($list)) foreach ($list as $item):?>
            <div class="row pb-3">
                <div class="col-2">
                    <?=date("d.m.Y H:i:s",strtotime($item->created_at))?>
                </div>
                <div class="col-4">
                    <?=$item->username?>
                    <?=$item->surname?>
                    <br>
                    <?=$item->phone?>
                </div>
                <div class="col-6">
                    <?=$item->faculty?><br>
                    <?=$item->speciality?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
