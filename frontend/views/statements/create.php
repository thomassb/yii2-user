<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Statements */

$this->title = Yii::t('app', 'Create Statements');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statements-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
