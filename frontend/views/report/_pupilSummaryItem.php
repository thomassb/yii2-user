<?php
/* @var $this yii\web\View */

?>


    <tr>
        <td colspan="2" class="active"><h2 class="margin-bottom-none"><?=($model[key($model)][0]['name'])?></h2></td>
    </tr>


    <?php
    foreach ($model as $key => $value) {
        if ($key != 'name') {
            ?>
            <tr>
                <td colspan="2" class="info"><?= $key ?></td>
            </tr>

            <?php
            foreach ($value as $level) {
                ?>
                <tr>
                    <td><?= $level["StrandText"] ?></td>
                    <td><?= $level["thelevel"] ?></td>
                </tr>
                <?php
            }
        }
        ?>


    </tr>
<?php }
?>






