<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Pupils */

$this->title = Yii::t('app', 'Create Pupils');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pupils'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pupils-create">

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

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>
 </div>
</div>
