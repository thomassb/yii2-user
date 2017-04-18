<?php

use yii\helpers\ArrayHelper;
use frontend\models\Classes;
use frontend\models\Pupils;
use yii\bootstrap\Html;
use kartik\daterange\DateRangePicker;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* $useDate 
 * $useStrand
 * $useSubject
 */
if (!isset($buttonText)) {
    $buttonText = 'Run Report';
}
?>  
<div class="col-sm-12">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?=
                \kartik\select2\Select2::widget([
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
                <?= Html::activeHiddenInput($reportForm, 'PupilID') ?>
                <div id="ajpupil">
                    <?php
                    $url = \yii\helpers\Url::to(['/pupils/ajax-pupil-search/']);
                    $pupilInital = empty($reportForm->PupilID) ? '' : [$reportForm->PupilID => Pupils::findOne($reportForm->PupilID)->FullName];
                    echo \kartik\select2\Select2::widget([
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
    <?php if (!isset($useSubject) || $useSubject !== false): ?>
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
                    echo \kartik\select2\Select2::widget([
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
        <?php
    endif;

    if (!isset($useStrand) || $useStrand !== false):
        ?>
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
                        'attribute' => 'strandID',
                        'model' => $reportForm,
                        'options' => ['placeholder' => 'Select ...'],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['formreport-subjectid'],
                            'url' => Url::to(['/strand/ajax-strand-subject']),
                            'loadingText' => 'Loading Strands ...',
                            'placeholder' => 'Select a Strand',
                            'params' => ['statements-pupilid', 'statements-displayalllevels']
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <?php
    endif;

    if (!isset($useLevel) || $useLevel !== false):
        ?>
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
                        'attribute' => 'levelID',
                        // 'id' => 'levelid',
                        'model' => $reportForm,
                        'options' => ['placeholder' => 'Select ...'],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => [ 'formreport-pupilid', 'formreport-strandid', 'formreport-subjectid'],
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
    endif;

    if (!isset($useDate) || $useDate !== false):
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group drp-container">
                        <?php
                        $addon = <<< HTML
<span class="input-group-addon"  title="Open Calendar">
    <i class="glyphicon glyphicon-calendar"></i>
                                
</span>

HTML;
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
                            <i class="glyphicon glyphicon-remove date-remove"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endif;

    if (isset($displayPupilPremium) && $displayPupilPremium === true):
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Display Only Pupil Premium</label>
                    <div class="input-group drp-container">

                        <?php
                        echo \kartik\widgets\SwitchInput::widget([
                            'model' => $reportForm,
                            'attribute' => 'PupilPremium',
                            'options' => ['class' => 'form-control'],
                            'pluginOptions' => [
                                'onText' => 'Yes',
                                'offText' => 'No'
                            ]
                        ])
                        ?>

                    </div>
                </div>
            </div>
        </div>
<?php endif; ?>




</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
<?= Html::submitButton($buttonText, ['class' => 'btn btn-primary', 'id' => 'statment-search']) ?>
        </div>
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