<?php
/* @var $this yii\web\View */

//use yii\widgets\ListView;
//use kartik\widgets\Select2;
//use yii\helpers\ArrayHelper;
//use frontend\models\Classes;
//use frontend\models\Pupils;
//use yii\bootstrap\Html;
//use kartik\daterange\DateRangePicker;
//use yii\web\JsExpression;
//use kartik\depdrop\DepDrop;
//use yii\helpers\Url;
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
        </div>
    </div>
    <div class="box-body">

        <?php
        yii\bootstrap\ActiveForm::begin([ 'method' => 'get']);
        ?>
        <?= $this->render('/common/_pupilSearchForm', ['reportForm' => $reportForm, 'useLevel' => false, 'useStrand' => false,'displayPupilPremium'=>true]) ?>
        <?php yii\bootstrap\ActiveForm::end(); ?>
    </div>
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







