<?php
/* @var $this yii\web\View */


?>


<tr>
    <td colspan="4" class="active">
        <h2 class="margin-bottom-none"><?= ($model[key($model)]['PupilName']) ?></h2>
    </td>
</tr>


<?php
foreach ($model as $key =>  $value) {
//     if ($key != 'PupilName') {
    ?>
 

    <?php
    foreach ($value as $level) {
        ?>
        
            <?php
                if (is_array($level)) {
                    foreach ($level as $level=> $Statements) {
                        //    echo print_r($Statement);
                        if (is_array($Statements)) {
                              echo '<tr ><td  colspan="4"><b>'.$level.'</b></td></tr>';
                            foreach ($Statements as $statment){
                                 
                            echo '<tr><td>'.$statment['StatementText'].'</td> '
                                    . '<td>'.\Yii::$app->formatter->asDatetime($statment['PartiallyDate'], "php:d-m-Y") .'</td> '
                                    . '<td>'.\Yii::$app->formatter->asDatetime($statment['AchievedDate'], "php:d-m-Y").'</td> '
                                    . '<td>'.\Yii::$app->formatter->asDatetime($statment['ConsolidatedDate'], "php:d-m-Y").'</td> </tr>';
                            }
                        } else {
                            //Strand name
                              echo '<tr class="warning"><td>'.$Statements.'</td>'
                                     . ' <td>Partially</td> '
                                    . '<td>Achieved</td> '
                                    . '<td>Consolidated</td></tr>';
                        }
                    }
                } else {
                    //Subject
                    echo '<tr class="info"><td colspan="4">'.$key.'</td></tr>';
                }
                ?>
           
        <?php
    }
 }
?>






