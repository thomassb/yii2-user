$('#statement-search').click(function () {
    if (!$('#statements-pupilid').val() ||
            !$('#levelid').val() ||
            !$('#strandid').val() ||
            !$('#subjectid').val()) {
        return false;
    }
    //validate
    //return false;
//    $(this).append("<i class='icon-spinner icon-spin icon-large spin address-search-load'></i>");
//                        $.ajax({
//                                type: 'GET',
//                                 dataType:'json',
//                               url:'" . yii\helpers\Url::toRoute('ajax-pupil-page') . "',
//                                data: {'Statements[PupilID]': $('#pupilid').val(),
//                                _csrf: '" . Yii::$app->request->getCsrfToken() . "' },
//                                   
//                                success: function (data) {
//                                
//                               
//                                if(data.status=='success'){
//                                var output = [];
//                                
//
//                                    }
//                                },
//                                error: function (XMLHttpRequest, textStatus, errorThrown) {
//                                       $('.address-search-load').hide();
//                                        $('#addresses').show();
//                                }
//                        });
//                       return false;
});    