app.controller('viewExamCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.examing = $window.examing;
    $scope.inputMode = 'key_input';
    $scope.allowedFileType = $scope.examing.allowed_file_type.split(",");

    // $scope.selectFileType = $scope.allowedFileType[0];
    $scope.groupData = findGroupDataByID($scope.examing.group_id);
    if($scope.examing.examing_mode === 'n'){
        $scope.examExaming = findExamExamingInViewExam($scope.examing.id,myuser.id);
    } else {
        $scope.examExaming = findExamRandomInViewExam($scope.examing.id,myuser.id);
    }
    $(document).ready(function () {
        $scope.selectFileType = $scope.allowedFileType[0];
    });
    $('#exam_content').Editor();
    //----------------------------------------------------------------------
    $scope.startExam = function (data) {
        $scope.CurrentIndex = $scope.examExaming.indexOf(data);
        $scope.examID = data.exam_id;
        $('#detail_exam_modal').modal({backdrop: 'static'});
        $('#detail_exam_part').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        var examData = findExamByID(data.exam_id).responseJSON;
        var keyword = findKeywordByEID(data.exam_id);
        $('#exam_name').html(examData.exam_name);
        $('#exam_time').html(examData.time_limit);
        $('#exam_memory').html(examData.memory_size);
        var examContent = readExamContent(examData);
        // examContent += '1&lt;div&gt;22&lt;&#x2F;div&gt;&lt;div&gt;333&lt;&#x2F;div&gt;&lt;div&gt;4444&lt;&#x2F;div&gt;&lt;div&gt;55555&lt;&#x2F;div&gt;';
        // examContent += '&lt;br&gt;&lt;div&gt;&lt;br&gt;&lt;&#x2F;div&gt;&lt;div&gt;&lt;span style=&quot;font-weight: bold;&quot;&gt;Keyword :&amp;nbsp;&lt;&#x2F;span&gt;&lt;&#x2F;div&gt;';
        // for (i = 0;i<keyword.length;i++){
        //     examContent += '&lt;blockquote style=&quot;margin: 0 0 0 40px; border: none; padding: 0px;&quot;&gt;- '+keyword[i].keyword_data+'&lt;&#x2F;blockquote&gt;';
        //     // examContent += keyword[i].keyword_data;
        //     examContent += '&lt;div&gt;';
        // }
        $('#exam_content').Editor('setText', decapeHtml(examContent));
        $('.Editor-editor').attr('contenteditable', false);
        $('[id^=menuBarDiv]').hide();
        $('[id^=statusbar]').hide();
        $('#full_score').html(examData.full_score);
        $('#imper_score').html(examData.accep_imperfect * examData.full_score / 100.0);
        $('#cut_wrongans').html(examData.cut_wrongans);
        $('#cut_comerror').html(examData.cut_comerror);
        $('#cut_overmemory').html(examData.cut_overmemory);
        $('#cut_overtime').html(examData.cut_overtime);
        $('#detail_exam_part').waitMe('hide');
    };
    //----------------------------------------------------------------------
    $scope.okSend = function () {
        var result = "";
        $('#notice_exam_key_ans').hide();
        $('#notice_exam_file_ans').hide();
        if($scope.inputMode === 'key_input'){
            if($scope.codeExam.length > 0){
                if($scope.selectFileType === "java"){
                    data = {
                        EMID : $scope.examing.id,
                        EID : $scope.examID,
                        UID : $window.myuser.id,
                        code : $scope.codeExam,
                        mode : "key"
                    };
                    result = sendExamJava(data);
                    console.log(result);
                }
            } else {
                $('#notice_exam_key_ans').html('* กรุณาใส่โค้ดโปรแกรม').show();
            }

        } else {

            if($("#file_ans")[0].files.length > 0){
                checkFile = checkFileType($("#file_ans")[0].files);
                if(checkFile){
                    $window.examID = $scope.examID;
                    $('#AnsFileForm').submit();
                    if($scope.selectFileType === "java"){
                        data = {
                            path : $window.exam_part,
                            EMID : $scope.examing.id,
                            EID : $scope.examID,
                            UID : $window.myuser.id,
                            mode : "file"
                        }
                    }
                }
            } else {
                $('#notice_exam_file_ans').html('* กรุณาเลือกไฟล์').show();
            }

        }
        // if($scope.selectFileType === "java"){
        //     if($scope.inputMode === 'key_input'){
        //         if($scope.codeExam.length > 0){
        //             data = {
        //                 code: $scope.codeExam,
        //                 mode: "key_input"
        //             }
        //         } else {
        //             $('#notice_exam_key_ans').html('* กรุณาใส่โค้ดโปรแกรม').show();
        //         }
        //     } else{
        //         checkFile = checkFileType($("#file_ans")[0].files);
        //         if(checkFile){
        //             $window.examID = $scope.examID;
        //             $('#AnsFileForm').submit();
        //         }
        //     }
        // }



    };
    //----------------------------------------------------------------------
    function decapeHtml(str) {
        str = str.replace(/&amp;/g, '&');
        str = str.replace(/&lt;/g, '<');
        str = str.replace(/&gt;/g, '>');
        str = str.replace(/&quot;/g, '"');
        str = str.replace(/&#39;/g, "'");
        str = str.replace(/&#x2F;/g, '/');
        return str;
    }
    //----------------------------------------------------------------------
    function getExtension(file) {
        var parts = file.name.split('.');
        return parts[parts.length - 1];
    }

    //----------------------------------------------------------------------
    function checkFileType(files) {
        for(i =0;i<files.length;i++){
            var ext = getExtension(files[i]);
            if (ext.toLowerCase() === $scope.selectFileType) {

            } else {
                    return false;
                }
        }
        return true;
    }
    //----------------------------------------------------------------------
    function sendExamJava(data) {
        var success = true;
        var sendExamJava = $.ajax({
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                Accept: "application/json"
            },
            url: url + '/sendExamJava',
            data:data,
            async: false,
            complete: function (xhr) {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        $scope.examExaming[$scope.CurrentIndex].current_status = 'Q';
                        // $scope.$apply();
                        $('#detail_exam_modal').modal('hide');
                    } else if (xhr.status == 209){
                        $('#detail_exam_modal').modal('hide');
                        $('#fail_package_modal').modal('show');
                        success = false;
                    } else {
                        success = false;
                        $('#unsuccess_modal').modal({backdrop: 'static'});
                    }
                }
            }
        }).responseJSON;
        result = {
            RQID :sendExamJava,
            success : success
        };
        return result;
    }
}]);