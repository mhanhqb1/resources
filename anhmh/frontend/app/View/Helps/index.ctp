<?php foreach ($helps as $help):?>
<div class="helpTitle helpTitle<?php echo $help['id'];?>">
    <?php echo $help['title'];?>
</div>
<div class="hlpDetail hlpDetail<?php echo $help['id'];?>">
    <?php
        if ($help['content'] != strip_tags($help['content'])) {
            echo $help['content'];
        } else {
            echo nl2br($help['content']);
        }
    ?>
</div>
<?php endforeach;?>