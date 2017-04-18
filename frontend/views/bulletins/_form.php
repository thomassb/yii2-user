<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Bulletins */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bulletins-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
    <?=
    $form->field($model, 'created')->widget(\kartik\widgets\DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Enter date...'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]);
    ?>
    <?=
    $form->field($model, 'category')->widget(kartik\select2\Select2::classname(), [
        'data' => \frontend\models\Bulletins::Categories(),
        'options' => ['placeholder' => Yii::t('app', 'Select a caregory ...')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?=
    $form->field($model, 'active')->widget(\kartik\widgets\SwitchInput::classname(), [
           
         
    ]);
    ?>
<?=
$form->field($model, 'sticky')->widget(\kartik\widgets\SwitchInput::classname(), [
        //  'options' => ['placeholder' => 'Enter date of birth ...'],
]);
?>



    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
