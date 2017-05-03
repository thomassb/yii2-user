<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\widgets\ReportListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\Bulletins */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bulletins');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bulletins-index">
    <div class="box box-solid ">
        <div class="box-header bg-blue-gradient">
            <i class="fa fa-calendar"></i>

            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <!-- tools box -->
            <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bars"></i></button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <?php
                        if (Yii::$app->user->can("EditBulletins")) {
                            echo " <li><?= Html::a('New bulletin', ['bulletins/create']); ?></li>";
                            echo '   <li class="divider"></li>';
                        }
                        ?>
                        <li><?= Html::a('View bulletins', ['bulletins']); ?></li>
                    </ul>
                </div>

            </div>
            <!-- /. tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body ">

            <?php
            echo ReportListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => [],
                'itemView' => '_bulletin',
                // 'summary' => '',
                'layout' => '{summary}
               <div id="timeline" class="tab-pane active">
                <ul class="timeline timeline-inverse">{items}<li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul> </div>{pager}',
            ]);
            ?> 

        </div>
        <!-- /.box-body -->
        <div class="box-footer text-black">

            <!-- /.row -->
        </div>
    </div>


</div>
