<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\PupilStartingLevel */

$this->title = Yii::t('app', 'Create Pupil Starting Level');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pupil Starting Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pupil-starting-level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
