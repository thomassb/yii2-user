<?php
/* @var $this yii\web\View */


use yii\widgets\ListView;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Classes;
use frontend\models\Pupils;


use yii\bootstrap\Html;

use yii\web\JsExpression;

$this->title = Yii::t('app', 'Assessment Grid');
$this->params['breadcrumbs'][] = Yii::t('app', 'Reports');;
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
            yii\bootstrap\ActiveForm::begin([ 'method' => 'post']);
            ?>
  
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">

                        <?php
                        $url = \yii\helpers\Url::to(['/pupils/ajax-pupil-search']);
                        $pupilInital= empty($reportForm->pupilID) ? '' : Pupils::findOne($reportForm->pupilID)->FullName;
                        echo Select2::widget([
                            'attribute' => 'pupilID',
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
                                'templateResult' => new JsExpression('function(pupilID) { return pupilID.text; }'),
                                'templateSelection' => new JsExpression('function (pupilID) { return pupilID.text; }'),
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>

  
        </div>  
        <div class="row"><div class="col-md-6">
                <div class="form-group">
                    <?= Html::submitButton('Run Report', ['class' => 'btn btn-primary', 'id' => 'statment-search']) ?>
                </div>
            </div>
        </div>
        <?php yii\bootstrap\ActiveForm::end(); ?>
    </div>

</div>












