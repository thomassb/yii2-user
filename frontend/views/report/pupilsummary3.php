<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use yii\widgets\ListView;
use kartik\export\ExportMenu;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Classes;
use frontend\models\Pupils;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\bootstrap\Html;
use kartik\daterange\DateRangePicker;

$this->title = Yii::t('app', 'Summary Reports');
$this->params['breadcrumbs'][] = Yii::t('app', 'Reports');
;
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
            <h3 class="box-title">Summary Report<br><small><?= $reportForm->NiceFilterName() ?></small></h3>
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
            <?php
            $count = $pupilData->getCount();
            $summaryOptions = [];
            $tag = ArrayHelper::remove($summaryOptions, 'tag', 'div');
            $totalCount = $pages->totalCount;
            $begin = $pages->getPage() * $pages->pageSize + 1;
            $end = $begin + $count - 1;
            if ($begin > $end) {
                $begin = $end;
            }
            $page = $pages->getPage() + 1;
            $pageCount = $pages->pageCount;

            echo Html::tag($tag, Yii::t('yii', 'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{pupil} other{pupils}}.', [
                        'begin' => $begin,
                        'end' => $end,
                        'count' => $count,
                        'totalCount' => $totalCount,
                        'page' => $page,
                        'pageCount' => $pageCount,
                            ], $summaryOptions));
            ?>


            <?php
            echo common\widgets\ReportListView::widget([
                'dataProvider' => $pupilData,
                'itemOptions' => [],
                'itemView' => '_pupilSummaryItem',
                'summary' => '',
                'layout' => "\n<table class=\"table table-condensed\"> <tbody>\n{items} </tbody></table>\n",
            ]);
            ?> 

            <div id="custom-pagination">
                <?php
                if ($pages) {
                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                    ]);
                }
                ?>
            </div>

        </div>





    </div>


<?php endif; ?>



