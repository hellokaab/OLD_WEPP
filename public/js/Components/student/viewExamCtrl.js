app.controller('viewExamCtrl', ['$scope', '$window', function ($scope, $window) {
    $scope.examing = $window.examing;
    $scope.inputMode = 'key_input';
    $scope.groupData = findGroupDataByID($scope.examing.group_id);
    if($scope.examing.examing_mode === 'n'){
        $scope.examExaming = findExamExamingInViewExam($scope.examing.id,myuser.id);
    } else {
        $scope.examExaming = findExamRandomInViewExam($scope.examing.id,myuser.id);
    }
    console.log($scope.examExaming);
    $('#exam_content').Editor();
    //----------------------------------------------------------------------
    $scope.startExam = function (data) {

        $('#detail_exam_modal').modal({backdrop: 'static'});
        $('#detail_exam_part').waitMe({
            effect: 'win8_linear',
            bg: 'rgba(255,255,255,0.9)',
            color: '#3bafda'
        });
        var examData = findExamByID(data.exam_id).responseJSON;
        var keyword = findKeywordByEID(data.exam_id);
        console.log(examData);
        console.log(keyword);
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
        $('#AnsFileForm').submit();
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
}]);