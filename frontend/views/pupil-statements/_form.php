<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PupilStatements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pupil-statements-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PupilID')->textInput() ?>

    <?= $form->field($model, 'StatementID')->textInput() ?>

    <?= $form->field($model, 'PartiallyDate')->textInput() ?>

    <?= $form->field($model, 'AchievedDate')->textInput() ?>

    <?= $form->field($model, 'ConsolidatedDate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
