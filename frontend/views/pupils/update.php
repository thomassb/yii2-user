<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Pupils */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Pupils',
        ]) . $model->FullName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pupils'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID ." -  $model->FullName", 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pupils-update">

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

            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Starting Levels</h3>
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
            <div class="form-group field-pupils-classid required">
                <div class="row">
                    <div class="col-xs-8">

                        <?=
                        Select2::widget([
                            'data' => ArrayHelper::map(\frontend\models\Strands::find()->all(), 'ID', 'StrandText'),
                            'name' => 'StrandID',
                            'id' => 'addstrandid',
                            'options' => ['placeholder' => Yii::t('app', 'Select a strand ...')],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-xs-3">

                        <?=
                        Select2::widget([
                            'data' => ArrayHelper::map(\frontend\models\Levels::find()->all(), 'ID', 'LevelText'),
                            'name' => 'levelID',
                            'id' => 'addlevelid',
                            'options' => ['placeholder' => Yii::t('app', 'Select a level ...')],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-xs-1">
                        <button class="add-item btn btn-success btn-xs" type="button" id="addStartingLevel">
                            <i class="glyphicon glyphicon-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?=
                    GridView::widget([
                        'dataProvider' => $startinglevels,
                        'id' => 'startinglevelsgrid',
                        'pjax' => true,
                            //  'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'strand.StrandText',
                    ['header'=>'Starting Level',
                        'attribute'=>  'level.LevelText']
                  ,
                    ['format' => 'raw',
                        'value' => function($model, $key, $index) {
                            return \yii\bootstrap\Html::button(' <i class="glyphicon glyphicon-minus"></i>', ['class' => 'remove-item btn btn-danger btn-xs', 'title' => 'Remove strand', 'data-rowid' => $model->ID]);
                        }]
                        // ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
  <?php
        $this->registerJs(" $('#addStartingLevel').click(function(){
   
    if($('#addstrandid').val()=='' ||$('#addlevelid').val()=='')
    return false;
    $(this).append(\"<i class='icon-spinner icon-spin icon-large spin address-search-load'></i>\");
                        $.ajax({
                                type: 'POST',
                                 dataType:'json',
                               url:'" . yii\helpers\Url::toRoute('pupil-starting-level/add') . "',
                                data: {strandid: $('#addstrandid').val(),
                                levelid: $('#addlevelid').val(),
                                  pupil:'" . $model->ID . "',
                                _csrf: '" . Yii::$app->request->getCsrfToken() . "',
                                  },
                                   
                                success: function (data) {
                                
                               
                                if(data.status=='success'){
                             $('#startinglevelsgrid').yiiGridView('applyFilter');
                             }
                             else{alert(data.errors);}
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                       $('.address-search-load').hide();
                                      
                                }
                        });
                       return false;
                  });
$(document).on('click', '.remove-item', function() {

   var rowid = $(this).data('rowid');
       alert(rowid);
    if(rowid=='')
    {return false;}
    $(this).append(\"<i class='icon-spinner icon-spin icon-large spin address-search-load'></i>\");
                        $.ajax({
                                type: 'POST',
                                 dataType:'json',
                               url:'" . yii\helpers\Url::toRoute('pupil-starting-level/remove') . "',
                                data: {rowid: rowid,
                                
                                _csrf: '" . Yii::$app->request->getCsrfToken() . "',
                                  },
                                   
                                success: function (data) {
                                
                               
                                if(data.status=='success'){
                             $('#startinglevelsgrid').yiiGridView('applyFilter');
                             }
                             else{alert(data.errors);}
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                       $('.address-search-load').hide();
                                      
                                }
                        });
                       return false;
                  });


", yii\web\View::POS_END, 'startinglevels');
        ?>