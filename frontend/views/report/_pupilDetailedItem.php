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
                    foreach ($level as $Statments) {
                        //    echo print_r($Statment);
                        if (is_array($Statments)) {

                            echo '<tr><td>'.$Statments['StatementText'].'</td> '
                                    . '<td>'.$Statments['ConsolidatedDate'].'</td> '
                                    . '<td>'.$Statments['AchievedDate'].'</td> '
                                    . '<td>'.$Statments['PartiallyDate'].'</td> </tr>';
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






