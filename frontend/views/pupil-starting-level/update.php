<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PupilStartingLevel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Pupil Starting Level',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pupil Starting Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pupil-starting-level-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
