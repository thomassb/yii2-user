<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\PupilStatements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pupil-statements-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PupilID') ?>

    <?= $form->field($model, 'StatementID') ?>

    <?= $form->field($model, 'PartiallyDate') ?>

    <?= $form->field($model, 'AchievedDate') ?>

    <?php // echo $form->field($model, 'ConsolidatedDate') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
