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
?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Pupil Statements - <?= $pupil->FullName ?>: 
            <?= $searchModel->subject->Subject ?>->
            <?= $searchModel->strand->StrandText ?>->
            <?= $searchModel->level->LevelText ?></h3>
<!--        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
            <button class="btn btn-box-tool" data-widget="remove">
                <i class="fa fa-remove"></i>
            </button>
        </div>-->
    </div>
    <div class="box-body">
        <div class="col-sm-12">

            <?php
            $searchModel->PupilID = $pupil->ID;
            $pupilid = $pupil->ID;
            $columns = [
                //['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT],
                //               'ID',
                //               'pupilStatement.ID',
                'StatementText',
//                'PupilID',
//                'LevelID',
//                'StrandID',
                [
                    'format' => 'raw',
                    'value' => function($model, $key, $index) use($pupilid) {
                        $pk = $model->pupilStatement->ID; // ($model->pupilStatement->ID)?$model->pupilStatement->ID:$pupilid.'-'.$model->ID;
                        return'<span class="x-edit editable-click" data-type="date" data-pk="' . $pk . '" data-url="' .
                                Url::to(['tracker/ajax-save', 'StatementID' => $model->ID,
                                    'PupilID' => $pupilid, 'Type' => 'PartiallyDate', 'PupilStatementID' => $model->pupilStatement->ID])
                                . '">' . $model->pupilStatement->PartiallyDate;
                    },
                    'header' => 'Partially Date',
                    'width' => '140px',
                ],
                [
                    'format' => 'raw',
                    'value' => function($model, $key, $index) use($pupilid) {
                        $pk = $model->pupilStatement->ID; // ($model->pupilStatement->ID)?$model->pupilStatement->ID:$pupilid.'-'.$model->ID;
                        return'<span class="x-edit editable-click" data-type="date" data-pk="' . $pk . '" data-url="' .
                                Url::to(['tracker/ajax-save', 'StatementID' => $model->ID,
                                    'PupilID' => $pupilid, 'Type' => 'AchievedDate', 'PupilStatementID' => $model->pupilStatement->ID])
                                . '">' . $model->pupilStatement->AchievedDate;
                    },
                    'header' => 'Achieved Date',
                    'width' => '140px',
                ],
                [
                    'format' => 'raw',
                    'value' => function($model, $key, $index) use($pupilid) {
                        $pk = $model->pupilStatement->ID; // ($model->pupilStatement->ID)?$model->pupilStatement->ID:$pupilid.'-'.$model->ID;
                        return'<span class="x-edit editable-click" data-type="date" data-pk="' . $pk . '" data-url="' .
                                Url::to(['tracker/ajax-save', 'StatementID' => $model->ID,
                                    'PupilID' => $pupilid, 'Type' => 'ConsolidatedDate', 'PupilStatementID' => $model->pupilStatement->ID])
                                . '">' . $model->pupilStatement->ConsolidatedDate;
                    },
                    'header' => 'Consolidated Date',
                    'width' => '140px',
                        ],
//                [
//                    'class' => 'kartik\grid\EditableColumn',
//                    'value' => 'pupilStatement.PartiallyDate',
//                    'header' => 'Partially Date',
//                    //'attribute' => "AchievedDate",
//                    //    'format'=>'raw',
//                    'editableOptions' => function ($model, $key, $index) {
//                        return [
//                            'header' => 'Partially Date',
//                            'name' => 'PartiallyDate',
//                            //'format'=>'raw',
//                            'inputType' => \kartik\editable\Editable::INPUT_DATE,
//                            'displayValue' => isset($model->pupilStatement->PartiallyDate) ? $model->pupilStatement->PartiallyDate : '',
//                            'value' => isset($model->pupilStatement->PartiallyDate) ? $model->pupilStatement->PartiallyDate : \Yii::$app->formatter->asDatetime(time(), "php:d/m/Y"), // 'pupilStatement.AchievedDate',
//                            'options' => ['id' => 'patialdate-' . $model->ID . '-' . $model->PupilID . '-' . $model->StrandID . '-' . $model->LevelID],
//                            'placement' => kartik\popover\PopoverX::ALIGN_LEFT,
//                            'asPopover' => false,
//                        ];
//                    },
//                            'hAlign' => 'right',
//                            'vAlign' => 'middle',
//                            'width' => '140px',
//                        ],
//                        [
//                            'class' => 'kartik\grid\EditableColumn',
//                            'value' => 'pupilStatement.AchievedDate',
//                            'header' => 'Achieved Date',
//                            //'attribute' => "AchievedDate",
//                            //    'format'=>'raw',
//                            'editableOptions' => function ($model, $key, $index) {
//                                return [
//                                    'pjaxContainerId' => 'dynagrid-' . $model->PupilID . '-' . $model->StrandID . '-' . $model->LevelID . '-pjax',
//                                    'header' => 'Achieved Date',
//                                    'name' => 'AchievedDate',
//                                    //'format'=>'raw',
//                                    'inputType' => \kartik\editable\Editable::INPUT_DATE,
//                                    'displayValue' => isset($model->pupilStatement->AchievedDate) ? $model->pupilStatement->AchievedDate : '',
//                                    'value' => isset($model->pupilStatement->AchievedDate) ? $model->pupilStatement->AchievedDate : \Yii::$app->formatter->asDatetime(time(), "php:d/m/Y"), // 'pupilStatement.AchievedDate',
//                                    'options' => ['id' => 'AchievedDate-' . $model->ID . '-' . $model->PupilID . '-' . $model->StrandID . '-' . $model->LevelID],
//                                    'placement' => kartik\popover\PopoverX::ALIGN_LEFT,
//                                    'asPopover' => false,
//                                ];
//                            },
//                                    'hAlign' => 'right',
//                                    'vAlign' => 'middle',
//                                    'width' => '140px',
//                                ],
//                                [
//                                    'class' => 'kartik\grid\EditableColumn',
//                                    'value' => 'pupilStatement.ConsolidatedDate',
//                                    'header' => 'Consolidated Date',
//                                    //'attribute' => "AchievedDate",
//                                    //    'format'=>'raw',
//                                    'editableOptions' => function ($model, $key, $index) {
//                                        return [
//                                            'header' => 'Consolidated Date',
//                                            'name' => 'ConsolidatedDate',
//                                            //'format'=>'raw',
//                                            'inputType' => \kartik\editable\Editable::INPUT_DATE,
//                                            'displayValue' => isset($model->pupilStatement->ConsolidatedDate) ? $model->pupilStatement->ConsolidatedDate : '',
//                                            'value' => isset($model->pupilStatement->ConsolidatedDate) ? $model->pupilStatement->ConsolidatedDate : \Yii::$app->formatter->asDatetime(time(), "php:d/m/Y"), // 'pupilStatement.AchievedDate',
//                                            'options' => ['id' => 'ConsolidatedDate-' . $model->ID . '-' . $model->PupilID . '-' . $model->StrandID . '-' . $model->LevelID],
//                                            'placement' => kartik\popover\PopoverX::ALIGN_LEFT,
//                                                // 'asPopover' => false,
//                                        ];
//                                    },
//                                            'hAlign' => 'right',
//                                            'vAlign' => 'middle',
//                                            'width' => '140px',
//                                        ],
                                    ];
                                    echo GridView::widget([
                                        'columns' => $columns,
                                        //'storage' => DynaGrid::TYPE_COOKIE,
                                        ///'theme' => 'panel-warning',
                                        'options' => ['id' => 'dynagrid-' . $searchModel->PupilID . '-' . $searchModel->StrandID . '-' . $searchModel->LevelID],
                                        //'floatHeader'=>true,
                                        'pjax' => true,
                                        'pjaxSettings' => [
                                            'options' => [
                                                'id' => 'dynagrid-' . $searchModel->PupilID . '-' . $searchModel->StrandID . '-' . $searchModel->LevelID . '-pjax']],
                                        // 'gridOptions' => [
                                        'responsive' => true,
                                        'condensed' => true,
                                        'dataProvider' => $dataProvider,
                                        'filterModel' => $searchModel,
                                        //  'showPageSummary' => true,
                                        'panel' => [
                                            'heading' => '',
                                            'before' => ''
                                        ],
                                            //]
                                    ]);
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

    $('.x-edit').editable({
        url: function () {
            var d = new $.Deferred();
            if ('value' === 'abc') {
                return d.reject('error message'); //returning error via deferred object
            } else {
                //async saving data in js model

                d.resolve();
            }

            return d.promise();
        }
    });


</script>