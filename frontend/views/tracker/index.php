<?php
/* @var $this yii\web\View */

use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Classes;
use yii\helpers\Url;
use yii\bootstrap\Html;
use common\widgets\editable\EditableDatePickerAsset;
use yii\web\JsExpression;
$view = $this;

EditableDatePickerAsset::register($view);

$this->title = Yii::t('app', 'Pupil Tracker');
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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?=
                        Select2::widget([
                            'name' => 'classid',
                            'id' => 'classid',
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
                          $url = \yii\helpers\Url::to(['/pupils/ajax-pupil-search']);
                        $pupilInital= empty($reportForm->pupilID) ? '' : Pupils::findOne($reportForm->pupilID)->FullName;
                        echo Select2::widget([
                            'attribute' => 'PupilID',
                            'model' => $searchModel,
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
                            'name' => 'subjectid',
                            'id' => 'subjectid',
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

                        <?php
                        echo DepDrop::widget([
                            // 'name' => 'strandid',
                           // 'id' => 'strandid',
                            'attribute' => 'StrandID',
                            'model' => $searchModel,
                            'options' => ['placeholder' => 'Select ...'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => ['subjectid'],
                                'url' => Url::to(['/strand/ajax-strand-subject']),
                                'loadingText' => 'Loading Strands ...',
                                'placeholder' => 'Select a Strand',
                                'params'=>['statements-pupilid', 'statements-displayalllevels']
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
                        <?php
                        echo DepDrop::widget([
                            //'name' => 'Statements[LevelID]',
                            'attribute' => 'LevelID',
                           // 'id' => 'levelid',
                            'model' => $searchModel,
                            'options' => ['placeholder' => 'Select ...'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => [ 'statements-pupilid','statements-strandid','subjectid' ],
                                'url' => Url::to(['/level/ajax-level-strand']),
                                'loadingText' => 'Loading Levels ...',
                                'placeholder' => 'Select a Level',
                                'params' => ['statements-pupilid', 'statements-displayalllevels']
                ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <?php
           /* if(Yii::$app->user->can("admin")):?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
      
                        <?php
                        echo \common\classes\bootckbox::widget(['model' => $searchModel,
                            'attribute' => 'displayAllLevels','id'=>'statements-displayalllevels',
                             'options'=>[
        'value'=>5,
        'uncheck'=>7
    ]]);
                     
                        ?>
                    </div>
                </div>
            </div>
            <?php else:{ 
             //   echo \yii\helpers\Html::hiddenInput('Statements[displayAllLevels]','0',['id'=>'statements-displayalllevels']);
            }
            endif;
            */
             ?>
            
            <div class="row"><div class="col-md-6">
                    <div class="form-group">
                        <?= Html::button('Search', ['class' => 'btn btn-primary', 'id' => 'statment-search']) ?>
                    </div>
                </div>
            </div>

        </div>

    </div>





</div>



<div id="pupil-tracking-table"></div>



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


