<?php
/* @var $this yii\web\View */
?>


<tr>
    <td colspan="3" class="active">
        <h2 class="margin-bottom-none"><?= ($model['name']) ?></h2>
    </td>
</tr>
<?php
foreach ($model['levels'] as $key=>$subject) {
   // if (is_array($level)) {
    //    print_r($level);
      echo '<tr class="info"><td>' . $key . '</td> '
        . '<td>Starting Level</td><td>Date</td></tr>';
    foreach ($subject as $level) {
         echo '<tr><td>' . $level['strand'] . '</td> '
        . '<td>' . $level['Level'] . '</td> <td>' . ($level['Date']=='0000-00-00 00:00:00'?'':\Yii::$app->formatter->asDate($level['Date'],'php:d-m-Y')) . '</td></tr>';
    }
       
  //  }
}












