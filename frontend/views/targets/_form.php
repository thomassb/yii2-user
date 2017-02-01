<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Targets */
/* @var $form yii\widgets\ActiveForm */

$levels = \frontend\models\LevelsText::find()->all();
$selectLevels = ArrayHelper::map($levels, 'ID', 'LevelText');
$yeargroup = str_replace(' ', '', strtolower($yeargroup->YearGroup));
$year = $yeargroup;

$_yearNumber = preg_split('/[^\d]+/', $year);
$yearNumber='';
if(count($_yearNumber) == 2){
    $yearNumber=$_yearNumber[1];
}
$yesterYear = false;
$yonderYear = false;

if (count($yearNumber) == 2 && $yearNumber[1] > 1) {
    $yesterYear = $yearNumber[1] - 1;
}
if (count($yearNumber) == 2 && $yearNumber[1] < 15) {
    $yonderYear = $yearNumber[1] + 1;
}
?>

<div class="targets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
//    echo $form->field($model, $attribute)
//    $form->field($model, 'PupilID')->textInput() ;
//
//    $form->field($model, 'created')->textInput();<?= yii\bootstrap\Html::button('View All Years') 
    ?>
    
    <table class="table table-condensed table-striped table-condensed">
        <tr>
            <th>Strand</th>
            <th>Target Year <?= $yesterYear ?></th>
            <th>Reviewed Target Year <?= $yesterYear ?></th>

            <th>Target Year <?=$yearNumber?></th>
            <th>Reviewed Target Year <?=$yearNumber?></th>
<!--            <th>Target Year <?= $yonderYear ?></th>
            <th>Reviewed Target Year <?= $yonderYear ?></th>-->
        </tr>



        <?php
        foreach ($model as $target) {
            //   echo ;
            //current year only
//         var_dump(count($yearNumber[1]));
//    exit;
            echo' <tr>
            <td>' . $listOfStrands[$target->StrandID] . '</td>';
            if ($yesterYear !== false) {
                $t = $target[('year' . $yesterYear) . 'Target'];
                if ($t) {
                    echo"<td>{$selectLevels[$t]}</td>";
                } else {
                    echo"<td>-</td>";
                }
                   $rt = $target[('year' . $yesterYear) . 'ReviewedTarget'];
                if ($rt) {
                    echo"<td>{$selectLevels[$rt]}</td>";
                } else {
                    echo"<td>-</td>";
                }
              
            } else {
                echo "<td>-</td>";
                echo "<td>-</td>";
            }
            echo '       <td>' . $form->field($target, '[id' . $target->id . ']' . '[sid' . $target->StrandID . ']' . $year . 'Target')
                    ->dropDownList($selectLevels, ['class' => 'form-control year input-sm', 'prompt' => ''])
                    ->label(false) . '</td>
                         <td>' . $form->field($target, '[id' . $target->id . ']' . '[sid' . $target->StrandID . ']' . $year . 'ReviewedTarget')
                    ->dropDownList($selectLevels, ['class' => 'form-control year input-sm', 'prompt' => ''])
                    ->label(false) . '</td>';
              // <td>' . $form->field($target, '[id' . $target->id . ']' . '[sid' . $target->StrandID . ']' . $year . 'ReviewedTarget')->textInput(['class' => 'form-control year input-sm'])->label(false) . '</td>';
//            if ($yonderYear !== false) {
//                echo"<td>{$target[('year' . $yonderYear) . 'Target']}</td>";
//                echo"<td>{$target[('year' . $yonderYear) . 'ReviewedTarget']}</td>";
//            } else {
//                echo "<td>-</td>";
//                echo "<td>-</td>";
//            }
            echo' </tr>';

            //  <span class="x-edit editable-click" data-type="select"> ; .input-group.input-group-sm
            // echo $form->field($target, $year.'ReviewedTarget')->textInput(['class'=>'form-control year1']);
            /* ?>
              <?= $form->field($target, 'year1Target')->textInput(['class'=>'form-control year1']) ?>

              <?= $form->field($target, 'year1ReviewedTarget')->textInput(['class'=>'form-control year1']) ?>

              <?= $form->field($target, 'year2Target')->textInput() ?>

              <?= $form->field($target, 'year2ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year3Target')->textInput() ?>

              <?= $form->field($target, 'year3ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year4Target')->textInput() ?>

              <?= $form->field($target, 'year4ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year5Target')->textInput() ?>

              <?= $form->field($target, 'year5ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year6Target')->textInput() ?>

              <?= $form->field($target, 'year6ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year7Target')->textInput() ?>

              <?= $form->field($target, 'year8ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year9Target')->textInput() ?>

              <?= $form->field($target, 'year9ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year10Target')->textInput() ?>

              <?= $form->field($target, 'year10ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year11Target')->textInput() ?>

              <?= $form->field($target, 'year11ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year12Target')->textInput() ?>

              <?= $form->field($target, 'year12ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year13Target')->textInput() ?>

              <?= $form->field($target, 'year13ReviewedTarget')->textInput() ?>

              <?= $form->field($target, 'year14Target')->textInput() ?>

              <?= $form->field($target, 'year14ReviewedTarget')->textInput() ?>
              <?php
             * 
             *  
             */
        }
        ?>
    </table>
    <div class="form-group">
    <?= Html::submitButton($model[0]->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model[0]->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
