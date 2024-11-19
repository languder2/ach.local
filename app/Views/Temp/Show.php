<?php if(isset($list)) foreach ($list as $item):?>
<pre>
[
    "code"          => "<?=$item->code?>",
    "name"          => "<?=$item->name?>",
    "level"         => "<?=$item->level?>",
    "faculty"       => "<?=$item->faculty?>",
    "department"    => 1,
],
</pre>
<?php endforeach;?>

