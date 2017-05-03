<?php
/* @var $this yii\web\View */
?>


<tr>
    <td colspan="4" class="active">
        <h2 class="margin-bottom-none"><?= ($model['PupilName']) ?></h2>
    </td>
</tr>


<?php
$subject = false;
foreach ($model as $key => $value) {
    if ($key != 'PupilName') {
     
        ?>


        <?php
        foreach ($value as $level) {
            ?>

            <?php
            if (is_array($level)) {
  echo '<tr class="warning"><td><b>' . $level['Strand']['strandText'] . '</b> Working in Level: ' . $level['Strand']['level'] . '</td>'
                        . ' <td>Partially</td> '
                        . '<td>Achieved</td> '
                        . '<td>Consolidated</td></tr>';
                foreach ($level as $skey=>$Statements) {
                    //    print_r($Statements);
                    if (is_array($Statements)&& $skey!='Strand' ) {

                        echo '<tr><td>' . $Statements['StatementText'] . '</td> '
                        . '<td>' . \Yii::$app->formatter->asDatetime($Statements['PartiallyDate'], "php:d-m-Y")  . '</td> '
                        . '<td>' . \Yii::$app->formatter->asDatetime($Statements['AchievedDate'], "php:d-m-Y") . '</td> '
                        . '<td>' . \Yii::$app->formatter->asDatetime($Statements['ConsolidatedDate'], "php:d-m-Y") . '</td> </tr>';
                    } else {
                        //Strand name
//                        echo '<tr class="warning"><td>' . $Statements . '</td>'
//                        . ' <td>Consolidated</td> '
//                        . '<td>Achieved</td> '
//                        . '<td>Partially</td></tr>';
                    }
                }
            } else {


                //Subject
                echo '<tr class="info"><td colspan="4"><h4>' . $key . '</h4></td></tr>';
            }
            ?>

            <?php
        }
    }
}
?>






