<?php
/* @var $this yii\web\View */

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Classes;
use frontend\models\Pupils;
use yii\bootstrap\Html;
use yii\web\JsExpression;

$this->title = Yii::t('app', 'Pupil Targets');
$this->params['breadcrumbs'][] = Yii::t('app', 'Admin');
;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Pupil Selection</h3>
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
yii\bootstrap\ActiveForm::begin([ 'method' => 'get']);
?>
              <?= $this->render('/common/_pupilSearchForm', ['reportForm'=>$reportForm,'useDate'=>false,'useLevel' => false, 'useStrand' => false])?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
<?=
Select2::widget([
    'attribute' => 'classID',
    'model' => $reportForm,
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
$url = \yii\helpers\Url::to(['/pupils/ajax-pupil-search']);
$pupilInital = empty($reportForm->PupilID) ? '' : Pupils::findOne($reportForm->PupilID)->FullName;
echo Select2::widget([
    'attribute' => 'PupilID',
    'model' => $reportForm,
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
        'templateResult' => new JsExpression('function(PupilID) { return PupilID.text; }'),
        'templateSelection' => new JsExpression('function (PupilID) { return PupilID.text; }'),
    ],
]);
?>
                    </div>
                </div>
            </div>



            <div class="row"><div class="col-md-6">
                    <div class="form-group">
<?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'statment-search']) ?>
                    </div>
                </div>
            </div>
<?php yii\bootstrap\ActiveForm::end(); ?>
        </div>

    </div>
</div>
<?php if ($pupilData): ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Targets<br><small><?= $reportForm->NiceFilterName() ?></small></h3>
            <div class="box-tools pull-right">

                <!--                <div class="btn-group">
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
                                </div>-->

                <!--            <button class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-remove"></i>
                            </button>-->
            </div>
        </div>
        <div class="box-body">


         
    <?php
    echo $this->render('_form', [
        'model' => $pupilData,
        'pupil' => $pupil,
         'listOfStrands'=>$listOfStrands,
        'yeargroup'=>$yeargroup
    ]);
    //print_r($pupilData);
//    echo ListView::widget([
//        'dataProvider' => $pupilData,
//        'itemOptions' => [],
//        'itemView' => '_pupilSummaryItem',
//        'summary' => '',
//    ]);
    ?> 

        </div>





    </div>


<?php endif; ?>











