<?php
/* @var $this yii\web\View */
?>
<table class="table  table-condensed">
    <?php
    foreach ($pupilData->getModels() as $model) {
        ?>  
        <tr>
            <td colspan="4" class="active">
                <h2 class="margin-bottom-none"><?= ($model[key($model)]['PupilName']) ?></h2>
            </td>
        </tr>


        <?php
        foreach ($model as $key => $value) {
//     if ($key != 'PupilName') {
            ?>


            <?php
            foreach ($value as $level) {
                ?>

                <?php
                $rowodd = 0;
                if (is_array($level)) {
                    foreach ($level as $levelText => $Statements) {
                        //    echo print_r($Statement);
                        if (is_array($Statements)) {

                            echo '<tr ><td  colspan="4"><b>' . $levelText . '</b></td></tr>';
                            foreach ($Statements as $statment) {
                                if ($rowodd % 2 == 0) {
                                    $row = "even";
                                } else {
                                    $row = 'odd';
                                }
                                echo '<tr class="' . $row . '"><td>' . $statment['StatementText'] . '</td> '
                                . '<td>' . $statment['PartiallyDate'] . '</td> '
                                . '<td>' . $statment['AchievedDate'] . '</td> '
                                . '<td>' . $statment['ConsolidatedDate'] . '</td> </tr>';
                                $rowodd++;
                            }
//                            echo '<tr "><td>' . $Statements['StatementText'] . '</td> '
//                            . '<td>' . $Statements['ConsolidatedDate'] . '</td> '
//                            . '<td>' . $Statements['AchievedDate'] . '</td> '
//                            . '<td>' . $Statements['PartiallyDate'] . '</td> </tr>';
                        } else {
                            //Strand name
                            echo '<tr  class="warning"><td >' . $Statements . '</td>'
                            . ' <td>Partially</td> '
                            . '<td >Achieved</td> '
                            . '<td >Consolidated</td></tr>';
                        }
                    }
                } else {
                    //Subject
                    echo '<tr ><td colspan="4" class="info">' . $key . '</td> </tr>';
                }
                ?>


                <?php
            }
            // }
            ?>



            <?php
        }
        echo ' <tr class="spacer">
                    <td></td>
                    <td></td>
                </tr>';
    }
    ?>

</table>