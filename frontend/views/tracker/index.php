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
             
           
  <?= $this->render('/common/_pupilSearchForm', ['reportForm'=>$searchModel,'useDate'=>false,'buttonText'=>'Search'])?>
          
           
            
           
            
            

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
if(!$('#formreport-pupilid').val()||
                                !$('#formreport-levelid').val()||
                               !$('#formreport-strandid').val()||
                                !$('#formreport-subjectid').val())
         return false;                       
   //validate
    //
    $(this).append(\"<i class='icon-spinner icon-spin icon-large spin address-search-load'></i>\");
                        $.ajax({
                                type: 'GET',
                                 
                               url:'" . yii\helpers\Url::toRoute('ajax-pupil-page') . "',
                                data: {'Statements[PupilID]': $('#formreport-pupilid').val(),
                                'Statements[LevelID]': $('#formreport-levelid').val(),
                                'Statements[StrandID]': $('#formreport-strandid').val(),
                                'Statements[SubjectID]': $('#formreport-subjectid').val(),
                                
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


