<?php
/* @var $this yii\web\View */

use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Classes;
use yii\helpers\Url;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\widgets\DetailView;
?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Pupil Statements</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button class="btn btn-box-tool" data-widget="remove">
                <i class="fa fa-remove"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-sm-12">

            <?php
            $columns = [
                //['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT],

                'StatementText',
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'value' => 'pupilStatement.PartiallyDate',
                    'attribute' => "PartiallyDate",
                    //'format'=>'raw',
                    'editableOptions' => [
                        'header' => 'PartiallyDate',
                        'inputType' => \kartik\editable\Editable::INPUT_DATE,
                        'options' => [],
                         'placement' => kartik\popover\PopoverX::ALIGN_LEFT,
                    ],
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'width' => '140px',
                ],
                 [
                    'class' => 'kartik\grid\EditableColumn',
                    //'value' => 'pupilStatement.AchievedDate',
                     'value' =>function($model) {
		            return  'http://twitter.com/' ;
	            },
                    'attribute' => "AchievedDate",
                //    'format'=>'raw',
                    'editableOptions' => [
                        'header' => 'AchievedDate',
                        'name'=>'AchievedDate',
                        //'format'=>'raw',
                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                      //  'value' =>'sds',// 'pupilStatement.AchievedDate',
                        'options' => [],
                        'placement' => kartik\popover\PopoverX::ALIGN_LEFT,
                       // 'asPopover' => false,
                           
                    ],
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'width' => '140px',
                ],
                 [
                    'class' => 'kartik\grid\EditableColumn',
                    'value' => 'pupilStatement.ConsolidatedDate',
                    'attribute' => "ConsolidatedDate",
                    //'format'=>'raw',
                    'editableOptions' => [
                        'header' => 'ConsolidatedDate',
                        'inputType' => \kartik\editable\Editable::INPUT_DATE,
                        'options' => [],
                         'placement' => kartik\popover\PopoverX::ALIGN_LEFT,
                    ],
                    'hAlign' => 'right',
                    'vAlign' => 'middle',
                    'width' => '140px',
                ],
//    [
//        'attribute' => 'pupil.AchievedDate',
//        
//        'format' => 'raw',
//        'width' => '140px',
//        'filterWidgetOptions' => [
//            'pluginOptions' => ['format' => 'yyyy-mm-dd','data-th'=>'AchievedDate']
//        ],
//    ],
//    [
//        'attribute' => 'pupil.ConsolidatedDate',
//        
//        'format' => 'raw',
//        'width' => '140px',
//        'filterWidgetOptions' => [
//            'pluginOptions' => ['format' => 'yyyy-mm-dd']
//        ],
//    ],
                    //  ['class' => 'kartik\grid\CheckboxColumn', 'order' => DynaGrid::ORDER_FIX_RIGHT],
            ];  
                    DetailView::widget([
        'model' => $data,
        'attributes' => [
            'ID',
            'PartiallyDate',
        ],
    ]);
//            echo GridView::widget([
//                'columns' => $columns,
//                //'storage' => DynaGrid::TYPE_COOKIE,
//                ///'theme' => 'panel-warning',
//                'options' => ['id' => 'dynagrid-1',],
//                //'floatHeader'=>true,
//                'pjax' => true,
//                // 'gridOptions' => [
//                'responsive' => true,
//                'condensed' => true,
//                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
//                //  'showPageSummary' => true,
//                'panel' => [
//                    'heading' => '',
//                    'before' => ''
//                ],
//                    //]
//            ]);
            ?></div>
    </div>
</div>
<script>
    var headertext = [];
    var headers = document.querySelectorAll("thead");
    var tablebody = document.querySelectorAll("tbody");

    for (var i = 0; i < headers.length; i++) {
        headertext[i] = [];
        for (var j = 0, headrow; headrow = headers[i].rows[0].cells[j]; j++) {
            var current = headrow;
            headertext[i].push(current.textContent);
        }
    }

    for (var h = 0, tbody; tbody = tablebody[h]; h++) {
        for (var i = 0, row; row = tbody.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                col.setAttribute("data-th", headertext[h][j]);
            }
        }
    }
</script>