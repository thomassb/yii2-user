<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Classes;
use frontend\models\Pupils;
use yii\bootstrap\Html;
use kartik\daterange\DateRangePicker;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\widgets\ReportListView;

$this->title = Yii::t('app', 'Detailed Reports');
$this->params['breadcrumbs'][] = Yii::t('app', 'Reports');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Pupil and Level Selection</h3>
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
        <div class="col-sm-12">
            <?php
            yii\bootstrap\ActiveForm::begin([ 'method' => 'get', 'action' => ['report/detailed/']]);
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?=
                        \Select2::widget([
                            'attribute' => 'classID',
                            'model' => $reportForm,
                            'data' => ArrayHelper::map(Classes::ClassList(), 'ID', 'ClassName'),
                            'options' => ['placeholder' => 'Select a Class ...', 'class' => 'select2 select2-container select2-container--default '],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?= Html::activeHiddenInput($reportForm, 'pupilID') ?>
                        <div id="ajpupil">
                            <?php
                            $url = \yii\helpers\Url::to(['/pupils/ajax-pupil-search/']);
                            $pupilInital = empty($reportForm->PupilID) ? '' : [$reportForm->PupilID => Pupils::findOne($reportForm->PupilID)->FullName];
                            echo Select2::widget([
                                'attribute' => 'pupilIDAjax',
                                'model' => $reportForm,
//     'name' => 'pupilid',
//                                'id' => 'pupilid',
                                'initValueText' => $pupilInital, // set the initial display text
                                'options' => ['placeholder' => 'Search for a Pupil ...'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 3,
                                    'language' => [
                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                    ],
                                    'ajax' => [
                                        'url' => $url,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(pupilID) { return pupilID.text; }'),
                                    'templateSelection' => new JsExpression('function (pupilID) { return pupilID.text; }'),
                                ],
                            ]);
//        echo                DepDrop::widget([
//                           'name' => 'pupilid2',
//                            'id'=>'pupilid2',
//                           // 'attribute' => 'pupilID',
//                            'model' => $reportForm,
//                           // 'data' => ArrayHelper::map(\frontend\models\Pupils::PupilList(), 'ID', 'FullName'),
//                            'options' => ['placeholder' => 'Select a Pupil ....'],
//                            'type' => DepDrop::TYPE_SELECT2,
//                            'select2Options' => ['pluginOptions' => ['allowClear' => true,
//                                 'initValueText' => $pupilInital,
//                                    'minimumInputLength' => 3,
//                                    'language' => [
//                                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
//                                    ],
//                                    'ajax' => [
//                                        'url' => $url,
//                                        'dataType' => 'json',
//                                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
//                                    ],
//                                ]],
//                            'pluginOptions' => [
//                                'depends' => ['formreport-classid'],
//                                'url' => Url::to(['/pupils/ajax-class-pupil']),
//                                'loadingText' => 'Loading Pupils ...',
//                                'placeholder' => 'Select a Pupil ....'
//                            ]
//                        ]);
                            ?>
                        </div>
                        <div id="deppupil" style="display: none">
                            <?php
                            if ($reportForm->classID) {
                                $pdata = ArrayHelper::map(\frontend\models\Pupils::PupilList($reportForm->classID), 'ID', 'FullName');
                            } else {
                                $pdata = [];
                            }
                            echo DepDrop::widget([
//                                'name' => 'pupilid2',
//                                'id' => 'pupilid2',
                                'attribute' => 'pupilIDClass',
                                'model' => $reportForm,
                                'data' => $pdata,
                                'options' => ['placeholder' => 'Select a Pupil ....'],
                                'type' => DepDrop::TYPE_SELECT2,
                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                'pluginOptions' => [
                                    'depends' => ['formreport-classid'],
                                    'url' => Url::to(['/pupils/ajax-class-pupil']),
                                    'loadingText' => 'Loading Pupils ...',
                                    'placeholder' => 'Select a Pupil ....'
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
//                         echo $form->field($searchModel, 'SubjectID')->widget(Select2::classname(), [
//    
//    'data' => ArrayHelper::map(frontend\models\Subjects::SubjectList(), 'ID', 'Subject'),
//    'options'=>['id'=>'subjectid', 'placeholder'=>'Select ...'],
//    'pluginOptions'=>['allowClear'=>true],
//    
//]);
                        ?>
                        <?php
                        echo Select2::widget([
                            'attribute' => 'subjectID',
                            'model' => $reportForm,
                            'data' => ArrayHelper::map(frontend\models\Subjects::SubjectList(), 'ID', 'Subject'),
                            'options' => ['placeholder' => 'Select a Subject ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
                        $addon = <<< HTML
<span class="input-group-addon"  title="Open Calendar">
    <i class="glyphicon glyphicon-calendar"></i>
                                
</span>

HTML;
                        echo '<div class="input-group drp-container">';
                        echo DateRangePicker::widget([
                            'model' => $reportForm,
                            'attribute' => '_daterange',
                            'useWithAddon' => true,
                            'convertFormat' => true,
                            'presetDropdown' => true,
                            //  'options' => ['placeholder' => 'Date range ...'],
                            //  'startAttribute' => 'dateFrom',
                            //  'endAttribute' => 'dateTo',
                            'options' => ['class' => 'clearable-date form-control', 'placeholder' => 'Date range ...'],
                            'pluginOptions' => [
                                'locale' => ['format' => 'Y-m-d'],
//                                'removeButton' => true,
//                                'type' => kartik\widgets\DatePicker::TYPE_COMPONENT_PREPEND,
//                                'allowClear' => true,
                            ]
                        ]) . $addon;
                        ?>
                        <span class="input-group-addon date-remove" title="Clear field">
                            <i class="glyphicon glyphicon-remove"></i>
                        </span>
                    </div>



                </div>
            </div>
        </div>  
        <div class="row"><div class="col-md-6">
                <div class="form-group">
<?= Html::submitButton('Run Report', ['class' => 'btn btn-primary', 'id' => 'statement-search']) ?>
                </div>
            </div>
        </div>
<?php yii\bootstrap\ActiveForm::end(); ?>
    </div>

</div>


<?php
$this->registerJs(<<< JS
    $(document).ready(function () {
        if($('#formreport-classid').val()!=''){
            $('#deppupil').show();
            $('#ajpupil').hide();
        }
        $('#formreport-classid').change(function(){
            if($(this).val()==''){
                $('#formreport-pupilidajax').val('').trigger('change');
                $('#formreport-pupilidclass').val('').trigger('change');
                $('#deppupil').hide();
                $('#ajpupil').show();
            }
            else{
                $('#formreport-pupilidajax').val('').trigger('change');
                $('#formreport-pupilidclass').val('').trigger('change');
                $('#deppupil').show();
                $('#ajpupil').hide();
            }
        });
        $('#formreport-pupilidajax').on('select2:select', function (evt) {
          $('#formreport-pupilid').val($(this).val());
});
                $('#formreport-pupilidclass').on('select2:select', function (evt) {
          $('#formreport-pupilid').val($(this).val());
});
                        $('#formreport-pupilidclass').on('select2:unselect', function (evt) {
          $('#formreport-pupilid').val(null);
});
                                $('#formreport-pupilidajax').on('select2:unselect', function (evt) {
          $('#formreport-pupilid').val(null);
});

    });
JS
        , yii\web\View::POS_END, 'classpulpi');
?>


</div>
<?php if ($pupilData): ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Report</h3>
            <div class="box-tools pull-right">

                <div class="btn-group">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span> Export
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= Yii::$app->request->url ?>&pdf=1"><i class="fa  fa-file-pdf-o"></i>PDF</a>
                        </li>
                        <li>
                            <a href="<?= Yii::$app->request->url ?>&csv=1"><i class="fa  fa-file-pdf-o"></i>CSV</a>
                        </li>
                    </ul>
                </div>

                <!--            <button class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-remove"></i>
                            </button>-->
            </div>
        </div>
        <div class="box-body">


           <!--     <table class="kv-grid-table table table-bordered table-striped table-condensed kv-table-wrap">
                    <thead>
                    <th>Subject</th>
                    <th>Level</th>
                    </thead>
                    <tbody>-->
            <?php
            echo ReportListView::widget([
                'dataProvider' => $pupilData,
                //    'itemOptions' => [
                //'tag' => 'tr',],
                'itemView' => '_pupilDetailedItem',
                'summary' => "Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> pupils",
                //    'summary' => '',
                'layout' => "{summary}\n<table class=\"kv-grid-table table table-bordered table-striped table-condensed kv-table-wrap\"> <tbody>\n{items} </tbody>
        </table>\n{pager}",
            ]);
            ?> 
            <!--            </tbody>
                    </table>-->
            <div id="custom-pagination">
                <?php
//            echo \yii\widgets\LinkPager::widget([
//                'pagination' => $pages,
//            ]);
                ?>
            </div>

        </div>





    </div>
<?php endif; ?>







