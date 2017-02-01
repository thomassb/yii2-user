<?php
/* @var $this yii\web\View */

use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Classes;
use yii\helpers\Url;
use yii\bootstrap\Html;
use common\widgets\editable\EditableDatePickerAsset;
use kartik\daterange\DateRangePicker;

$view = $this;

EditableDatePickerAsset::register($view);

$this->title = Yii::t('app', 'Reports');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Filters</h3>
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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
                        $addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;
                        echo '<div class="input-group drp-container">';
                        echo DateRangePicker::widget([
                            'model' => $formReport,
                            'attribute' => '_daterange',
                            'useWithAddon' => true,
                            'convertFormat' => true,
                          //  'startAttribute' => 'dateFrom',
                          //  'endAttribute' => 'dateTo',
                            'pluginOptions' => [
                                'locale' => ['format' => 'Y-m-d'],
                            ]
                        ]) . $addon;
                        echo '</div>';
                        ?>

                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?=
                        Select2::widget([
                            'model' => $formReport,
                            'attribute' => 'classID',
                            'data' => ArrayHelper::map(Classes::ClassList(), 'ID', 'ClassName'),
                            'options' => ['placeholder' => 'Select a Class ...'],
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
//                        echo $form->field($searchModel, 'PupilID')->widget(DepDrop::classname(), [
//                            'type' => DepDrop::TYPE_SELECT2,
//                            'data' => ArrayHelper::map(\frontend\models\Pupils::PupilList(), 'ID', 'FullName'),
//                            'options' => ['placeholder' => 'Select a Pupil ....'],
//                            'type' => DepDrop::TYPE_SELECT2,
//                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
//                            'pluginOptions' => [
//                                'depends' => ['classid'],
//                                'url' => Url::to(['/pupils/ajax-class-pupil']),
//                                'loadingText' => 'Loading Pupils ...',
//                                'placeholder' => 'Select a Pupil ....'
//                            ]
//                        ]);
                        ?>
                        <?php
                        echo DepDrop::widget([
//                            'name' => 'pupilid',
//                            'id'=>'pupilid',
                            'attribute' => 'pupilID',
                            'model' => $formReport,
                            'data' => ArrayHelper::map(\frontend\models\Pupils::PupilList(), 'ID', 'FullName'),
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
                            'name' => 'subjectID',
                            'id' => 'subjectID',
                            'model' => $formReport,
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
//                        echo $form->field($searchModel, 'StrandID')->widget(DepDrop::classname(), [
//                            'type' => DepDrop::TYPE_SELECT2,
//                            //'data'=>[2 => 'Tablets'],
//                            'options' => ['id' => 'strandid', 'placeholder' => 'Select ...'],
//                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
//                            'pluginOptions' => [
//                                'depends' => ['subjectid'],
//                                'url' => Url::to(['/strand/ajax-strand-subject']),
//                            // 'params'=>['input-type-1', 'input-type-2']
//                            ]
//                        ]);
                        ?>


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?php
//                        echo $form->field($searchModel, 'LevelID')->widget(DepDrop::classname(), [
//                            'type' => DepDrop::TYPE_SELECT2,
//                            //'data'=>[2 => 'Tablets'],
//                            'options' => ['id' => 'levelid', 'placeholder' => 'Select ...'],
//                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
//                            'pluginOptions' => [
//                                'loadingText' => 'Loading Levels ...',
//                                'placeholder' => 'Select a Level',
//                                'depends' => ['subjectid', 'strandid'],
//                                'url' => Url::to(['/level/ajax-level-strand']),
//                            // 'params'=>['input-type-1', 'input-type-2']
//                            ]
//                        ]);
                        ?>

                    </div>
                </div>
            </div>
            <div class="row"><div class="col-md-6">
                    <div class="form-group">
                        <?= Html::button('Search', ['class' => 'btn btn-primary', 'id' => 'statment-search']) ?>
                    </div>
                </div>
            </div>

        </div>

    </div>





</div>



<div id="report-table"></div>



<?php
$this->registerJs(" 
     $(document).ready(function() {
        $('.x-edit').editable();
    });

$('#statment-search').click(function(){
if(!$('#statements-pupilid').val()||
                                !$('#statements-levelid').val()||
                               !$('#statements-strandid').val()||
                                !$('#subjectid').val())
         return false;                       
   //validate
    //
    $(this).append(\"<i class='icon-spinner icon-spin icon-large spin address-search-load'></i>\");
                        $.ajax({
                                type: 'GET',
                                 
                               url:'" . yii\helpers\Url::toRoute('ajax-pupil-page') . "',
                                data: {'Statements[PupilID]': $('#statements-pupilid').val(),
                                'Statements[LevelID]': $('#statements-levelid').val(),
                                'Statements[StrandID]': $('#statements-strandid').val(),
                                'Statements[SubjectID]': $('#subjectid').val(),
                                _csrf: '" . Yii::$app->request->getCsrfToken() . "' },
                                   
                                success: function (data) {
                                
                                $('#pupil-tracking-table').html(data);
                                $('.kv-editable-link').popover();
                                if(data.status=='success'){
                                var output = [];
                                

                                 }
                                },
                                error: function (XMLHttpRequest, textStatus, errorThrown) {
                                       $('.address-search-load').hide();
                                        $('#addresses').show();
                                }
                        });
                       return false;
                  });    


$('#pupilid').change(function(){
    
});

", yii\web\View::POS_END, 'search');
?>


