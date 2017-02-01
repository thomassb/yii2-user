<?php
/* @var $this yii\web\View */
?>


<tr>
    <td colspan="2" class="active">
        <h2 class="margin-bottom-none"><?= ($model['name']) ?></h2>
    </td>
</tr>
<?php
foreach ($model['levels'] as $key=>$subject) {
   // if (is_array($level)) {
    //    print_r($level);
      echo '<tr class="info"><td>' . $key . '</td> '
        . '<td>Starting Level</td></tr>';
    foreach ($subject as $level) {
         echo '<tr><td>' . $level['strand'] . '</td> '
        . '<td>' . $level['Level'] . '</td> </tr>';
    }
       
  //  }
}












