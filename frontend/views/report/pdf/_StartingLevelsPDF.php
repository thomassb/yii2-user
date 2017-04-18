<?php
/* @var $this yii\web\View */


?>
<table class="table  table-condensed">
   
    <?php
    foreach ($pupilData->getModels() as $model) {
     
      ?> 
        <tr>
        <td colspan="3" class="active"><h2 class="margin-bottom-none"><?= ($model['name']) ?></h2></td>
    </tr>


    <?php
    foreach ($model['levels'] as $key=>$subject) {
        if ($key != 'name') {
            ?>
            <tr>
                <td colspan="3" class="info"><?= $key ?></td>
            </tr>

            <?php
             $rowodd = 0;
            foreach ($subject as $level) {
//                print_r($level);
//                exit;
                if ($rowodd % 2 == 0) {
                                $row = "even";
                            } else {
                                $row = 'odd';
                            }
                ?>
                <tr class="<?= $row ?>">
                    <td><?= $level["strand"] ?></td>
                    <td><?= $level["Level"] ?></td>
                    <td><?= ($level['Date']=='0000-00-00 00:00:00'?'':\Yii::$app->formatter->asDate($level['Date'],'php:Y-m-d'))?> </td>
                </tr>
                <?php
                 $rowodd++;
            }
        }
        ?>



    <?php }
    echo ' <tr class="spacer">
                    <td></td>
                    <td></td>
                </tr>';
}
?>

</table>



