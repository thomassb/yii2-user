<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\PupilStatements */

$this->title = Yii::t('app', 'Create Pupil Statements');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pupil Statements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pupil-statements-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
