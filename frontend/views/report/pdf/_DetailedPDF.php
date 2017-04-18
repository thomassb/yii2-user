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
                    foreach ($level as $levelText => $Statments) {
                        //    echo print_r($Statment);
                        if (is_array($Statments)) {

                            echo '<tr ><td  colspan="4"><b>' . $levelText . '</b></td></tr>';
                            foreach ($Statments as $statment) {
                                if ($rowodd % 2 == 0) {
                                    $row = "even";
                                } else {
                                    $row = 'odd';
                                }
                                echo '<tr class="' . $row . '"><td>' . $statment['StatementText'] . '</td> '
                                . '<td>' . $statment['ConsolidatedDate'] . '</td> '
                                . '<td>' . $statment['AchievedDate'] . '</td> '
                                . '<td>' . $statment['PartiallyDate'] . '</td> </tr>';
                                $rowodd++;
                            }
//                            echo '<tr "><td>' . $Statments['StatementText'] . '</td> '
//                            . '<td>' . $Statments['ConsolidatedDate'] . '</td> '
//                            . '<td>' . $Statments['AchievedDate'] . '</td> '
//                            . '<td>' . $Statments['PartiallyDate'] . '</td> </tr>';
                        } else {
                            //Strand name
                            echo '<tr  class="warning"><td >' . $Statments . '</td>'
                            . ' <td>Consolidated</td> '
                            . '<td >Achieved</td> '
                            . '<td >Partially</td></tr>';
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