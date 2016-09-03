<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Classes */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Classes',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Classes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="classes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
