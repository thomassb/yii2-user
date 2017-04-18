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
$this->params['breadcrumbs'][] = Yii::t('app', 'Reports');
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
yii\bootstrap\ActiveForm::begin([ 'method' => 'post']);
?>

  <?= $this->render('/common/_pupilSearchForm', ['reportForm'=>$reportForm,'useDate'=>false,'useSubject'=>false,'useLevel' => false, 'useStrand' => false])?>




<?php yii\bootstrap\ActiveForm::end(); ?>
        </div>  
    </div>

</div>












