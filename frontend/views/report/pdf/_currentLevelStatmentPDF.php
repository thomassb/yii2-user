<?php
/* @var $this yii\web\View */
?>
<table class="table  table-condensed">
    <?php foreach ($pupilData->getModels() as $model) { ?>
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
                      $rowodd = 0;
                    if (is_array($level)) {
                        echo '<tr class="warning"><td><b>' . $level['Strand']['strandText'] . '</b> Current Level: ' . $level['Strand']['level'] . '</td>'
                        . ' <td>Consolidated</td> '
                        . '<td>Achieved</td> '
                        . '<td>Partially</td></tr>';
                        foreach ($level as $skey => $Statments) {
                               if ($rowodd % 2 == 0) {
                                $row = "even";
                            } else {
                                $row = 'odd';
                            }
                            //    print_r($Statments);
                            if (is_array($Statments) && $skey != 'Strand') {

                                echo '<tr class="' . $row . '"><td>' . $Statments['StatementText'] . '</td> '
                                . '<td>' . $Statments['ConsolidatedDate'] . '</td> '
                                . '<td>' . $Statments['AchievedDate'] . '</td> '
                                . '<td>' . $Statments['PartiallyDate'] . '</td> </tr>';
                                 $rowodd++;
                            } else {
                                //Strand name
//                        echo '<tr class="warning"><td>' . $Statments . '</td>'
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
    }
    ?>




</table>

