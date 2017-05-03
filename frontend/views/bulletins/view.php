<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\widgets\ReportListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Bulletins */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bulletins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bulletins-view">

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
                        <li><?= Html::a('New bulletin', ['bulletins/create']); ?></li>
                        <li class="divider"></li>
                        <li><?= Html::a('View bulletins', ['bulletins']); ?></li>
                    </ul>
                </div>

            </div>
            <!-- /. tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body ">
            <div id="timeline" class="tab-pane active">
                <ul class="timeline timeline-inverse">
                    <li class="time-label">
                        <span class="bg-red">
                            <?= $model->NiceDate ?>
                        </span>
                    </li>

                    <li>
                        <i class="fa fa-envelope bg-blue"></i>

                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> <?= $model->NiceTime ?></span>

                            <h3 class="timeline-header"><?= $model->title ?></h3>

                            <div class="timeline-body">
                                <?= $model->body ?>
                            </div>
                            <div class="timeline-footer">
                                <?php
                                if (Yii::$app->user->can("EditBulletins")) {

                                    echo Html::a('Edit', ['bulletins/update', 'id' => $model->id], [ 'class' => 'btn btn-success btn-xs']);
                                    echo ' ' . Html::a('Delete', ['bulletins/delete', 'id' => $model->id], [ 'class' => 'btn btn-danger btn-xs', 'data-confirm' => 'Are You sure', 'data-method' => 'post']);
                                }
                                ?>
                            </div>
                        </div>
                    </li> <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                    </li>
                </ul> </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer text-black">

            <!-- /.row -->
        </div>
    </div>

</div>
