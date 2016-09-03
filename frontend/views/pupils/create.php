<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Pupils */

$this->title = Yii::t('app', 'Create Pupils');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pupils'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pupils-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
