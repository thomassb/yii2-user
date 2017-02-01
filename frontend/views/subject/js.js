$('#addStrand').click(function () {

    if ($('#addstrandid').val() == '')
    {
        return false;
    }
    $(this).append("<i class='icon-spinner icon-spin icon-large spin address-search-load'></i>");
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url:'" . yii\helpers\Url::toRoute('subject / addstrand') . "',
                data: {strandid: $('#addstrandid').val(),
                    subjectid: '".$model->ID."',
                    _csrf: '" . Yii::$app->request->getCsrfToken() . "',
                },
        success: function (data) {


            if (data.status == 'success') {
                $('addstrandid').yiiGridView('applyFilter');
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            $('.address-search-load').hide();
        }
    });
    return false;
});
        