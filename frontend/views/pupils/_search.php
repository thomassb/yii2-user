<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\Pupils */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pupils-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'FirstName') ?>

    <?= $form->field($model, 'LastName') ?>

    <?= $form->field($model, 'ClassID') ?>

    <?= $form->field($model, 'DoB') ?>

    <?php // echo $form->field($model, 'UserID') ?>

    <?php // echo $form->field($model, 'SchoolID') ?>

    <?php // echo $form->field($model, 'Created') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
