<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\Subjects */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
            'modelClass' => 'Subject',
        ]) . $model->Subject;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subjects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Subject, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="subjects-update">


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
            <div class="row">
                <div class="col-xs-11">

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
                <div class="col-xs-1">
                    <button class="add-item btn btn-success btn-xs" type="button" id="addStrand">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                </div>
            </div>
            <?=
            GridView::widget([
                'dataProvider' => $strands,
                'id' => 'strandgrid',
                'pjax' => true,
                //  'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'area.StrandText',
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
        <?php
        $this->registerJs(" $('#addStrand').click(function(){
   
    if($('#addstrandid').val()=='')
    return false;
    $(this).append(\"<i class='icon-spinner icon-spin icon-large spin address-search-load'></i>\");
                        $.ajax({
                                type: 'POST',
                                 dataType:'json',
                               url:'" . yii\helpers\Url::toRoute('subject/addstrand') . "',
                                data: {strandid: $('#addstrandid').val(),
                                  subjectid:'" . $model->ID . "',
                                _csrf: '" . Yii::$app->request->getCsrfToken() . "',
                                  },
                                   
                                success: function (data) {
                                
                               
                                if(data.status=='success'){
                             $('#strandgrid').yiiGridView('applyFilter');
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
      
    if(rowid=='')
    {return false;}
    $(this).append(\"<i class='icon-spinner icon-spin icon-large spin address-search-load'></i>\");
                        $.ajax({
                                type: 'POST',
                                 dataType:'json',
                               url:'" . yii\helpers\Url::toRoute('subject/removestrand') . "',
                                data: {rowid: rowid,
                                
                                _csrf: '" . Yii::$app->request->getCsrfToken() . "',
                                  },
                                   
                                success: function (data) {
                                
                               
                                if(data.status=='success'){
                             $('#strandgrid').yiiGridView('applyFilter');
                             }
                             else{alert(data.errors);}
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                       $('.address-search-load').hide();
                                      
                                }
                        });
                       return false;
                  });


", yii\web\View::POS_END, 'search');
        ?>