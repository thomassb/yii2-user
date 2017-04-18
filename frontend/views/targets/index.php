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

        <?php
        yii\bootstrap\ActiveForm::begin([ 'method' => 'get']);
        ?>
        <?= $this->render('/common/_pupilSearchForm', ['reportForm' => $reportForm, 
            'useDate' => false, 'useSubject' => false,
            'useLevel' => false, 'useStrand' => false,
            'buttonText'=>'Find Pupil']) ?>






        <?php yii\bootstrap\ActiveForm::end(); ?>


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
                'listOfStrands' => $listOfStrands,
                'yeargroup' => $yeargroup
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











