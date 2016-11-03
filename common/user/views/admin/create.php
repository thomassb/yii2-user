<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\user\models\User $user
 * @var common\user\models\Profile $profile
 */
$this->title = Yii::t('user', 'Create {modelClass}', [
            'modelClass' => 'User',
        ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="market-create">

        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-remove"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">

                <?=
                $this->render('_form', [
                    'user' => $user,
                    'profile' => $profile,
                ])
                ?>
            </div>
        </div>
    </div>
</div>