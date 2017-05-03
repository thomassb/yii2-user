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
use kartik\form\ActiveForm;

$view = $this;

EditableDatePickerAsset::register($view);

$this->title = Yii::t('app', 'Import');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Import Existing SPAT Data</h3>
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

            <p>This operation can seriously affect any data already stored, may wipe all data or may make the software unable to run.
                <br>Please use <b>EXTREME CAUTION</b></p>
            <?php
//All files
            if ($allfiles !== true) {
                ?>
                <div class="alert alert-danger ">

                    <h4>
                        <i class="icon fa fa-ban"></i>
                        Missing Files!
                    </h4>
                    You have missing files please upload all required files.
                </div>
                <?php
            }
            ?>

            <div class="col-sm-6">
                <h3>Uploaded files</h3>
                <table class="table  table-bordered table-striped table-condensed">

                    <thead><th>File</th><th>Date</th></thead>
                    <tbody>
                        <?php
                        foreach ($files as $file) {
                            ?>
                            <tr>
                                <td><?= $file['name'] ?></td>
                                <td><?= $file['date'] ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <h3>Required files</h3>
                <table class="table table-bordered table-striped table-condensed">

                    <thead><th>File</th><th>Status</th></thead>
                    <tbody>
                        <?php
                        foreach ($fileList as $file) {
                            ?>
                            <tr>
                                <td><?= $file['name'] ?></td>
                                <td><?= $file['there'] === true ? '<span class="label label-success">Success</span>' : '<span class="label label-danger">Missing</span>' ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>




        </div>

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'import-form',
                                'options' => ['class' => 'form-horizontal',
                                    'enctype' => 'multipart/form-data'],
                                'fieldConfig' => [
                                // 'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
                                //  'labelOptions' => ['class' => 'col-lg-2 control-label'],
                                ],
                    ]);
                    ?>


                    <?=
                    $form->field($importform, 'files[]')->widget(kartik\widgets\FileInput::classname(), [
                        'options' => ['accept' => 'txt/*', 'multiple' => true],
                        'pluginOptions' => ['allowedFileExtensions' => ['txt'],
                            'showPreview' => false,
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => false
                    ]]);
                    ?>

                    <button class="btn btn-primary">Upload files</button>
                    <?php
                    if ($allfiles === true) {?>
                    <div>
                        <?php echo $form->field($importform, 'doimport')->dropDownList(['no' => 'No', 'no2' => 'No', 'yes' => 'Yes', 'no4' => 'No'], ['prompt'=>'Choose...']); ?>

                       
                        <button class="btn btn-block btn-danger btn-lg">Import data</button>
                    </div>
                    <?php }?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>





</div>









