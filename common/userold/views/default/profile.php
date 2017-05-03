<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\user\models\Profile $profile
 */
$this->title = Yii::t('user', 'Profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-default-profile">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
                <!--            <button class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-remove"></i>
                            </button>-->
            </div>
        </div>
        <div class="box-body">
            <?php if ($flash = Yii::$app->session->getFlash("Profile-success")): ?>

                <div class="alert alert-success">
                    <p><?= $flash ?></p>
                </div>

            <?php endif; ?>

            <?php
            $form = ActiveForm::begin([
                        'id' => 'profile-form',
                        'options' => ['class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-2 control-label'],
                        ],
                        'enableAjaxValidation' => true,
            ]);
            ?>
            <?php
            if ($profile->avatar) {
                ?>
                <div class="form-group ">
                    <label class="col-lg-2 control-label" >Profile Image</label>
                    <div class="col-lg-3">
                        <?= yii\bootstrap\Html::img('@web/uploads/users/' . $profile->avatar); ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?= $form->field($profile, 'full_name') ?>
            <?=
            $form->field($profile, 'image')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png']
            ]]);
            ?>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>




</div>