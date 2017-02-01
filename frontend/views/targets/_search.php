<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\Targets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="targets-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'PupilID') ?>

    <?= $form->field($model, 'created') ?>

    <?= $form->field($model, 'year1Target') ?>

    <?= $form->field($model, 'year1ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year2Target') ?>

    <?php // echo $form->field($model, 'year2ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year3Target') ?>

    <?php // echo $form->field($model, 'year3ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year4Target') ?>

    <?php // echo $form->field($model, 'year4ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year5Target') ?>

    <?php // echo $form->field($model, 'year5ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year6Target') ?>

    <?php // echo $form->field($model, 'year6ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year7Target') ?>

    <?php // echo $form->field($model, 'year8ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year9Target') ?>

    <?php // echo $form->field($model, 'year9ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year10Target') ?>

    <?php // echo $form->field($model, 'year10ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year11Target') ?>

    <?php // echo $form->field($model, 'year11ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year12Target') ?>

    <?php // echo $form->field($model, 'year12ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year13Target') ?>

    <?php // echo $form->field($model, 'year13ReviewedTarget') ?>

    <?php // echo $form->field($model, 'year14Target') ?>

    <?php // echo $form->field($model, 'year14ReviewedTarget') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
