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

 <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
                <!--            <button class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-remove"></i>
                            </button>-->
            </div>
        </div>
        <div class="box-body">
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
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}',
                    ],
            
            
        ],
//        'rowOptions' => function ($model, $key, $index, $grid) {
//                return ['class'=>'clickable-row', 'onclick' => 'alert(this.id);'];
//        },
    ]);
    ?>
        </div>
 </div>
</div>
