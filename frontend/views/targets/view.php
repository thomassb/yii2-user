<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Targets */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Targets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="targets-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'PupilID',
            'created',
            'year1Target',
            'year1ReviewedTarget',
            'year2Target',
            'year2ReviewedTarget',
            'year3Target',
            'year3ReviewedTarget',
            'year4Target',
            'year4ReviewedTarget',
            'year5Target',
            'year5ReviewedTarget',
            'year6Target',
            'year6ReviewedTarget',
            'year7Target',
            'year8ReviewedTarget',
            'year9Target',
            'year9ReviewedTarget',
            'year10Target',
            'year10ReviewedTarget',
            'year11Target',
            'year11ReviewedTarget',
            'year12Target',
            'year12ReviewedTarget',
            'year13Target',
            'year13ReviewedTarget',
            'year14Target',
            'year14ReviewedTarget',
        ],
    ]) ?>

</div>
