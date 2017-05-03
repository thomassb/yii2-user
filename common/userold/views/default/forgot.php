<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\user\models\forms\ForgotForm $model
 */

$this->title = Yii::t('user', 'Forgot password');
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];
?>
<div class="user-default-forgot">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>NODEq</b>uote</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">   <?= Html::encode($this->title) ?></p>
  
        <?php if ($flash = Yii::$app->session->getFlash('Forgot-success')): ?>

        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>

    <?php else: ?>

        <div class="row">
           
                <?php $form = ActiveForm::begin(['id' => 'forgot-form']); ?>
                 <?= $form
            ->field($model, 'email', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
                  
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('user', 'Submit'), ['class' => 'btn btn-primary btn-block btn-flat']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
          
        </div>

    <?php endif; ?></div>
 
  </div>
   

</div>
