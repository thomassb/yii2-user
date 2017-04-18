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
                    foreach ($level as $level=> $Statments) {
                        //    echo print_r($Statment);
                        if (is_array($Statments)) {
                              echo '<tr ><td  colspan="4"><b>'.$level.'</b></td></tr>';
                            foreach ($Statments as $statment){
                                 
                            echo '<tr><td>'.$statment['StatementText'].'</td> '
                                    . '<td>'.$statment['ConsolidatedDate'].'</td> '
                                    . '<td>'.$statment['AchievedDate'].'</td> '
                                    . '<td>'.$statment['PartiallyDate'].'</td> </tr>';
                            }
                        } else {
                            //Strand name
                              echo '<tr class="warning"><td>'.$Statments.'</td>'
                                     . ' <td>Consolidated</td> '
                                    . '<td>Achieved</td> '
                                    . '<td>Partially</td></tr>';
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






