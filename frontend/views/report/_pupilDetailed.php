<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
?>
<table class="table table-condensed">
    <?php
    $a='';
    echo ListView::widget([
        'dataProvider' => $pupilData,
        'itemOptions' => [],
      //  'itemView' => '_pupilSummaryItem',
    ]);
    ?>
</table>



