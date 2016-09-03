<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\Pupils */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pupils');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pupils-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Pupils'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ID',
            'FirstName',
            'LastName',
            [
                'attribute' => 'ClassName',
                'value' => 'class.ClassName',
            ],
            'DoB',
            // 'UserID',
            // 'SchoolID',
            // 'Created',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
