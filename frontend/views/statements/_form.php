<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Statements */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statements-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'StatementText')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'StrandID')->textInput() ?>

    <?= $form->field($model, 'LevelID')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
