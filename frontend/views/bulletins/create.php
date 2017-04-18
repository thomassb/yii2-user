<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Bulletins */

$this->title = Yii::t('app', 'Create Bulletins');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bulletins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bulletins-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
