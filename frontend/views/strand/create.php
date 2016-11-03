<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Strands */

$this->title = Yii::t('app', 'Create Strands');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Strands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="strands-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
