<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\Targets */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Targets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="targets-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Targets'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'PupilID',
            'created',
            'year1Target',
            'year1ReviewedTarget',
            // 'year2Target',
            // 'year2ReviewedTarget',
            // 'year3Target',
            // 'year3ReviewedTarget',
            // 'year4Target',
            // 'year4ReviewedTarget',
            // 'year5Target',
            // 'year5ReviewedTarget',
            // 'year6Target',
            // 'year6ReviewedTarget',
            // 'year7Target',
            // 'year8ReviewedTarget',
            // 'year9Target',
            // 'year9ReviewedTarget',
            // 'year10Target',
            // 'year10ReviewedTarget',
            // 'year11Target',
            // 'year11ReviewedTarget',
            // 'year12Target',
            // 'year12ReviewedTarget',
            // 'year13Target',
            // 'year13ReviewedTarget',
            // 'year14Target',
            // 'year14ReviewedTarget',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
