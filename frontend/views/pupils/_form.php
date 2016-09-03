<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

use common\models\Classes;
/* @var $this yii\web\View */
/* @var $model common\models\Pupils */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pupils-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'ClassID')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Classes::ClassList(), 'ID', 'ClassName'),
    'options' => ['placeholder' => 'Select a class ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
   

    <?= $form->field($model, 'DoB')->textInput() ?>

    <?= $form->field($model, 'UserID')->textInput() ?>

    <?= $form->field($model, 'SchoolID')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
